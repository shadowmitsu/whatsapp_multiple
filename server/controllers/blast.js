const { dbQuery } = require('../database'),
  { formatReceipt, prepareMediaMessage } = require('../lib/helper'),
  wa = require('../whatsapp'),
  fs = require('fs')
let inProgress = []
const updateStatus = async (campaignId, receiver, status) => {
    await dbQuery(
      "UPDATE blasts SET status = '" +
        status +
        "' WHERE receiver = '" +
        receiver +
        "' AND campaign_id = '" +
        campaignId +
        "'"
    )
  },
  checkBlast = async (campaignId, receiver) => {
    const result = await dbQuery(
      "SELECT status FROM blasts WHERE receiver = '" +
        receiver +
        "' AND campaign_id = '" +
        campaignId +
        "'"
    )
    return result.length > 0 && result[0].status === 'pending'
  }
const sendBlastMessage = async (req, res) => {
  const parsedData = JSON.parse(req.body.data),
    messageData = parsedData.data,
    campaignId = parsedData.campaign_id,
    delay = (ms) =>
      new Promise((resolve) => setTimeout(resolve, ms))
  if (inProgress[campaignId]) {
    return (
      console.log(
        'still any progress in campaign id ' +
          campaignId +
          ', request canceled. '
      ),
      res.send({ status: 'in_progress' })
    )
  }
  inProgress[campaignId] = true
  console.log('progress campaign ID : ' + campaignId + ' started')
  res.send({ status: 'in_progress' })
  const sendMessages = async () => {
    for (let index in messageData) {
      const delaySeconds = parsedData.delay
      await delay(delaySeconds * 1000)
      if (
        parsedData.sender &&
        messageData[index].receiver &&
        messageData[index].message
      ) {
        const isPending = await checkBlast(
          campaignId,
          messageData[index].receiver
        )
        if (isPending) {
          try {
            const isNumberExist = await wa.isExist(
              parsedData.sender,
              formatReceipt(messageData[index].receiver)
            )
            if (!isNumberExist) {
              await updateStatus(
                campaignId,
                messageData[index].receiver,
                'failed'
              )
              continue
            }
          } catch (error) {
            console.error('Error in wa.isExist: ', error)
            await updateStatus(
              campaignId,
              messageData[index].receiver,
              'failed'
            )
            continue
          }
          try {
            let sendResult
            if (parsedData.type === 'media') {
              const mediaMessage = JSON.parse(messageData[index].message)
			  if (mediaMessage.caption && mediaMessage.caption.trim() !== '') {
				if (mediaMessage.footer && mediaMessage.footer.trim() !== '') {
				  mediaMessage.caption = `${mediaMessage.caption}\n\n> _${mediaMessage.footer}_`;
				  delete mediaMessage.footer;
				}
			  } else if (mediaMessage.footer && mediaMessage.footer.trim() !== '') {
				mediaMessage.caption = `> _${mediaMessage.footer}_`;
				delete mediaMessage.footer;
			  }
              sendResult = await wa.sendMedia(
                parsedData.sender,
                messageData[index].receiver,
                mediaMessage.type,
                mediaMessage.url,
                mediaMessage.caption,
				0,
                mediaMessage.viewonce,
                mediaMessage.filename
              )
            }else if (parsedData.type === 'sticker') {
			  const stickerMessage = JSON.parse(messageData[index].message)
              sendResult = await wa.sendSticker(
                parsedData.sender,
                messageData[index].receiver,
                stickerMessage.type,
                stickerMessage.url,
                stickerMessage.filename
              )
			} else {
			  messageData[index].message = JSON.parse(messageData[index].message);
			  if (messageData[index].message.text && messageData[index].message.text.trim() !== '') {
					if (messageData[index].message.footer && messageData[index].message.footer.trim() !== '') {
						messageData[index].message.text = wa.randomizeText(`${messageData[index].message.text}\n\n> _${messageData[index].message.footer}_`);
						delete messageData[index].message.footer;
					}
			  }
              sendResult = await wa.sendMessage(
                parsedData.sender,
                messageData[index].receiver,
                messageData[index].message
              )
            }
            const sendStatus = sendResult ? 'success' : 'failed'
            await updateStatus(
              campaignId,
              messageData[index].receiver,
              sendStatus
            )
          } catch (sendError) {
            console.error(sendError)
            sendError.message.includes('503')
              ? (console.log(
                  'Server is busy, waiting for 5 seconds before retrying...'
                ),
                await delay(5000),
                index--)
              : await updateStatus(
                  campaignId,
                  messageData[index].receiver,
                  'failed'
                )
          }
        } else {
          console.log('no pending, not send!')
        }
      } else {
        console.log('wrong data, progress canceled!')
      }
    }
    delete inProgress[campaignId]
  }
  sendMessages().catch((error) => {
    console.error('Error in send operation: ' + error)
    delete inProgress[campaignId]
  })
}
module.exports = { sendBlastMessage: sendBlastMessage }
