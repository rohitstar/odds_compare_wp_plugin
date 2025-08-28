document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.odds-compare');
    blocks.forEach((block) => {
        const event = block.dataset.event;
        const market = block.dataset.market;
        const bookmakers = block.dataset.bookmakers;
        const format = block.dataset.format;

        fetch(`/wp-json/odds-compare/v1/odds?event=${event}&market=${market}&bookmakers=${bookmakers}&format=${format}`)
            .then((response) => response.json())
            .then((data) => {
                block.innerHTML = data.map((item) => `
                    <div class="odds-item">
                        <span>${item.bookmaker}</span>: <span>${item.odds_decimal || item.odds}</span>
                    </div>
                `).join('');
            })
            .catch(() => {
                block.innerHTML = '<p>Error loading odds.</p>';
            });
    });
});