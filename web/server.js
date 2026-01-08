/**
 * GitHub App Server for Monday.com App Web Integration
 * Handles webhook events from GitHub Marketplace
 */

const express = require('express');
const { createNodeMiddleware, createProbot } = require('probot');
const app = require('./app');

const port = process.env.PORT || 3000;
const host = process.env.NODE_ENV === 'production' ? '0.0.0.0' : 'localhost';

async function startServer() {
  const probot = createProbot();
  const middleware = createNodeMiddleware(app, { probot });
  
  const server = express();
  server.use(middleware);
  
  server.listen(port, host, () => {
    console.log(`Server is listening for events at: http://${host}:${port}/api/webhook`);
  });
}

startServer();
