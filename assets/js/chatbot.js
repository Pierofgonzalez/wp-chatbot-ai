document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('wp-chatbot-input');
    const sendBtn = document.getElementById('wp-chatbot-send');
    const messages = document.getElementById('wp-chatbot-messages');

    const appendMessage = (text, sender = 'user') => {
        const msg = document.createElement('div');
        msg.textContent = (sender === 'bot' ? '🤖 ' : '🧑 ') + text;
        messages.appendChild(msg);
        messages.scrollTop = messages.scrollHeight;
    };

    sendBtn.addEventListener('click', async () => {
        const message = input.value.trim();
        if (message === '') return;

        appendMessage(message, 'user');
        input.value = '';

        const response = await fetch(ChatbotAI.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': ChatbotAI.nonce
            },
            body: JSON.stringify({ message })
        });

        const result = await response.json();
        appendMessage(result.response || 'Error', 'bot');
    });
});
