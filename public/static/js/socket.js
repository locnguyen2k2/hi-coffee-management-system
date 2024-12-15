class SocketClient {
    constructor() {
        if (SocketClient.instance) {
            return SocketClient.instance;
        }

        SocketClient.instance = this;

        this.conn = null;
        this.isReady = false;

        this.initWebSocket();
    }

    initWebSocket() {
        this.conn = new WebSocket('ws://localhost:8080');

        this.conn.onopen = () => {
            console.log('WebSocket connection established');
            this.isReady = true;
        };

        this.conn.onclose = () => {
            console.log('WebSocket connection closed');
            this.isReady = false;
        };

        this.conn.onerror = (error) => {
            console.error('WebSocket error:', error);
        };

        this.conn.onmessage = (event) => {
            console.log('Message:', event.data);
        };
    }

    async send(data) {
        // Ensure connection is ready before sending
        if (!this.isReady) {
            console.warn('WebSocket is not ready. Message not sent.');
            return;
        }

        this.conn.send(data);
    }
}

const wsConnection = () => {
    return new SocketClient();
};

const wsSendMessage = async (data) => {
    const client = wsConnection();
    await client.send(data);
};

try {
    wsSendMessage('Finished')
} catch (e) {
    console.log('The settings for websocket is finished')
}
