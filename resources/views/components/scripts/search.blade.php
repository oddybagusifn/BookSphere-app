@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const bookCards = document.querySelectorAll('.book-card');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const keyword = this.value.trim().toLowerCase();

                    bookCards.forEach(card => {
                        const title = (card.dataset.title || '').toLowerCase();
                        const author = (card.dataset.author || '').toLowerCase();
                        const year = (card.dataset.year || '').toLowerCase();
                        const category = (card.dataset.category || '').toLowerCase();

                        const match = title.includes(keyword) ||
                                      author.includes(keyword) ||
                                      year.includes(keyword) ||
                                      category.includes(keyword);

                        card.classList.toggle('d-none', !match);
                    });
                });
            }
        });
    </script>
@endpush
