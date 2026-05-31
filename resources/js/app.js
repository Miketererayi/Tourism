/**
 * Tourism App — UI Interactions
 * - IntersectionObserver for scroll animations
 * - Scroll-to-top button
 */

// Scroll Animations via IntersectionObserver
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('[data-animate]');

    if (animatedElements.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        animatedElements.forEach(el => observer.observe(el));
    } else {
        // Fallback: show everything immediately
        animatedElements.forEach(el => el.classList.add('is-visible'));
    }

    // Stagger children
    const staggerContainers = document.querySelectorAll('.stagger-children');
    if (staggerContainers.length && 'IntersectionObserver' in window) {
        const staggerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    staggerObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.05,
            rootMargin: '0px 0px -20px 0px'
        });

        staggerContainers.forEach(el => staggerObserver.observe(el));
    } else {
        staggerContainers.forEach(el => el.classList.add('is-visible'));
    }
});

// Scroll-to-Top Button
(function() {
    const btn = document.getElementById('scroll-top-btn');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

// Cursor Glow Halo Effect
(function() {
    const hero = document.getElementById('heroArea');
    const halo = document.getElementById('cursorHalo');
    if (!hero || !halo) return;

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        halo.style.left = `${x}px`;
        halo.style.top = `${y}px`;
    });

    hero.addEventListener('mouseenter', () => {
        halo.style.opacity = '1';
    });

    hero.addEventListener('mouseleave', () => {
        halo.style.opacity = '0';
    });
})();

// AI Travel Concierge Logic
(function() {
    const btn = document.getElementById('conciergeBtn');
    const drawer = document.getElementById('conciergeDrawer');
    const closeBtn = document.getElementById('conciergeCloseBtn');
    const chat = document.getElementById('conciergeChat');
    const promptButtons = document.querySelectorAll('.concierge-prompt-btn');

    if (!btn || !drawer || !closeBtn || !chat) return;

    // Toggle Drawer
    btn.addEventListener('click', () => {
        drawer.classList.add('open');
    });

    closeBtn.addEventListener('click', () => {
        drawer.classList.remove('open');
    });

    // Close on clicking outside
    document.addEventListener('click', (e) => {
        if (!drawer.contains(e.target) && !btn.contains(e.target) && drawer.classList.contains('open')) {
            drawer.classList.remove('open');
        }
    });

    // Local Intelligence Responses
    const responses = {
        "What are the absolute must-visit attractions in Zimbabwe?": 
            "Zimbabwe is filled with legendary sights! 🇿🇼 Here are the absolute top spots:\n\n1. **Victoria Falls (Mosi-oa-Tunya)**: The world's largest sheet of falling water. A breathtaking natural wonder!\n2. **Great Zimbabwe Ruins**: An ancient stone city built in the 11th century that gave the country its name.\n3. **Mana Pools National Park**: A UNESCO World Heritage site famous for walking safaris and legendary standing elephants.\n4. **Matobo National Park**: Renowned for dramatic granite balancing rocks, ancient San bushman rock art, and wild rhino tracking.\n\n*Which of these wonders would you like to explore first?*",

        "Where can I find the best traditional or fine dining in Harare?": 
            "Harare is a thriving culinary hub! 🍲 Here are the top gourmet and local dining spots:\n\n- **Amanzi Restaurant**: Set in a lush botanical garden, famous for international fusion cuisine in a historic villa.\n- **The Victoria 22**: Ultra-premium luxury dining with a refined atmosphere, exquisite steaks, and curated fine wines.\n- **Gaby's Restaurant**: A fantastic place to experience high-end modern gourmet interpretations of traditional dishes.\n- **CoCo Wah Wah**: High energy, loved for its flame-grilled local platters, traditional sadza, and vibrant music.\n\n*Let me know if you would like me to help you find their contact info!*",

        "Can you plan a quick 2-day perfect itinerary for Victoria Falls?": 
            "Here is the ultimate **2-Day Perfect Itinerary** for Victoria Falls! 🌊\n\n* **Day 1: Rainforest & Sunset Cruise**\n  - *Morning*: Guided tour of the Victoria Falls Rainforest (bring a waterproof camera!).\n  - *Afternoon*: Helicopter flight ('Flight of Angels') for a spectacular 360° view of the gorge.\n  - *Sunset*: Cruise the upper Zambezi River with complimentary cocktails and wildlife sightings.\n* **Day 2: Adrenaline & Cultural Banquet**\n  - *Morning*: Walking safari or white-water rafting in the Batoka Gorge.\n  - *Lunch*: Dine at the Lookout Cafe, suspended 120m over the rapids.\n  - *Evening*: Enjoy The Boma Dinner & Drum Show for a spectacular feast of local meats and interactive drumming.\n\n*Would you like to book a tour guide for any of these activities?*",

        "Show me unique boutique hotels or safari lodges.": 
            "Zimbabwe hosts some of the most exclusive, award-winning safari lodges in Africa! 🦁 Here is our curated top tier:\n\n- **Singita Pamushana Lodge**: An ultra-luxury cliffside retreat overlooking Malilangwe Lake with breathtaking plunge pools.\n- **Somalisa Camp (Hwange)**: A magnificent tented lodge famous for its 'elephant pool' where majestic herds drink feet from your deck.\n- **The Victoria Falls Hotel**: A grand, historic Edwardian-era luxury hotel offering unparalleled views of the iconic Victoria Falls Bridge.\n- **Bumi Hills Safari Lodge**: High-end resort overlooking Lake Kariba with a stunning infinity pool and private safari charters.\n\n*Which lodge matches your dream vacation style?*"
    };

    let isTyping = false;

    // Handle Quick Prompts
    promptButtons.forEach(button => {
        button.addEventListener('click', async () => {
            if (isTyping) return;
            
            const promptText = button.getAttribute('data-prompt');
            const responseText = responses[promptText] || "I am currently looking that up in our directory. Please ask one of the quick prompts!";

            isTyping = true;
            disablePrompts(true);

            // 1. Append User Message Bubble
            appendBubble(promptText, 'user');

            // 2. Append Typing Indicator
            const typingIndicator = appendTypingIndicator();
            chat.scrollTop = chat.scrollHeight;

            // 3. Simulated API Network Delay
            await new Promise(r => setTimeout(r, 1200));

            // 4. Remove Typing Indicator
            typingIndicator.remove();

            // 5. Append Bot Message Bubble (Streamed character-by-character)
            const botBubble = appendBubble('', 'bot');
            chat.scrollTop = chat.scrollHeight;

            // 6. Stream Typewriter Effect
            await typewriter(responseText, botBubble);

            isTyping = false;
            disablePrompts(false);
        });
    });

    function disablePrompts(disable) {
        promptButtons.forEach(btn => {
            btn.disabled = disable;
            btn.style.opacity = disable ? '0.5' : '1';
            btn.style.cursor = disable ? 'not-allowed' : 'pointer';
        });
    }

    function appendBubble(text, sender) {
        const bubble = document.createElement('div');
        bubble.className = `concierge-bubble ${sender}`;
        
        if (sender === 'user') {
            bubble.textContent = text;
        } else {
            // Render markdown bold and lists elegantly
            bubble.innerHTML = formatMarkdown(text);
        }
        
        chat.appendChild(bubble);
        return bubble;
    }

    function appendTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'concierge-typing';
        indicator.innerHTML = '<span></span><span></span><span></span>';
        chat.appendChild(indicator);
        return indicator;
    }

    async function typewriter(text, element) {
        let currentText = "";
        for (let i = 0; i < text.length; i++) {
            currentText += text[i];
            element.innerHTML = formatMarkdown(currentText);
            chat.scrollTop = chat.scrollHeight;
            
            // Adjust typing speed dynamically based on character types
            let speed = 12;
            if (text[i] === '.' || text[i] === '!' || text[i] === '\n') {
                speed = 100; // Pause slightly at punctuation
            }
            await new Promise(r => setTimeout(r, speed));
        }
    }

    function formatMarkdown(text) {
        let html = text;
        // Bold formatting **text**
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Italic formatting *text*
        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
        // Newlines to breaks
        html = html.replace(/\n/g, '<br>');
        return html;
    }
})();
