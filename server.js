"use strict";

require("dotenv").config(); // Load .env early

const express = require("express");
const http = require("http");
const bodyParser = require("body-parser");
const { Server } = require("socket.io");

const wa = require("./server/whatsapp");
const dbs = require("./server/database/index");
const lib = require("./server/lib");
global.log = lib.log;

// EXPRESS SETUP
const app = express();
const server = http.createServer(app);
const port = process.env.PORT_NODE || 3000;

// SOCKET.IO SETUP (dengan path dan CORS)
const io = new Server(server, {
  path: "/socket.io", // penting untuk reverse proxy di CyberPanel
  cors: {
    origin: "*", // bisa diganti dengan domain frontend kamu
    methods: ["GET", "POST"]
  },
  pingInterval: 25000,
  pingTimeout: 10000,
});

// Middleware
app.use((req, res, next) => {
  res.set("Cache-Control", "no-store");
  req.io = io;
  next();
});

app.use(bodyParser.urlencoded({ extended: false, limit: "50mb", parameterLimit: 100000 }));
app.use(bodyParser.json());
app.use(express.static("src/public"));
app.use(require("./server/router"));

// Health check (optional)
app.get("/health", (req, res) => {
  res.send("OK");
});

// SOCKET.IO EVENTS
io.on("connection", (socket) => {
  console.log("🟢 User connected:", socket.id);

  socket.on("StartConnection", (data) => {
    wa.connectToWhatsApp(data, io);
  });

  socket.on("ConnectViaCode", (data) => {
    wa.connectToWhatsApp(data, io, true);
  });

  socket.on("LogoutDevice", (device) => {
    wa.deleteCredentials(device, io);
  });

  socket.on("disconnect", () => {
    console.log("🔴 User disconnected:", socket.id);
  });
});

// START SERVER
server.listen(port, () => {
  console.log(`✅ Server running on port: ${port}`);
});

// CONNECT TO WHATSAPP IF ALREADY SAVED
dbs.db.query("SELECT * FROM devices WHERE status = 'Connected'", (err, results) => {
  if (err) {
    console.error("❌ Error executing query:", err);
    return;
  }
  results.forEach(row => {
    const number = row.body;
    if (/^\d+$/.test(number)) {
      wa.connectToWhatsApp(number);
    }
  });
});
