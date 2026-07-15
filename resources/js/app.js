

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.searchBar = function () {
    return {
        query: '',
        results: [],
        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            const response = await fetch(`/search?q=${encodeURIComponent(this.query)}`);
            const data = await response.json();
            this.results = data.results;
        }
    }
}

Alpine.start();
