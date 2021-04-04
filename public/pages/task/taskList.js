export class TaskList {
    initialize() {
        this.container = document.querySelector('.task-list');
        if (!this.container) {
            return false;
        }

        this.pagination = this.container.querySelector('.task-list-pagination');
        this.sortPanel = this.container.querySelector('.task-list-sort');

        if (this.pagination) {
            this.bindPaginationEvents();
        }

        if (this.sortPanel) {
            this.bindSortPanelEvents();
        }
    }

    bindPaginationEvents() {
        this.pagination.addEventListener('click', (event) => this.onClickChangePage(event));
    }

    bindSortPanelEvents() {
        this.sortPanel.addEventListener('click', (event) => this.onClickSortPanelButton(event));
    }

    onClickChangePage(event) {
        event.preventDefault();

        let target = event.target;
        if (!target.dataset.hasOwnProperty('page')) {
            return false;
        }

        let pageNum = target.dataset.page;

        let url = new URL(location.href);
        url.searchParams.set('page', pageNum);
        location.replace(url.toString());
    }

    onClickSortPanelButton(event) {
        event.preventDefault();

        let target = event.target;
        if (!target.dataset.hasOwnProperty('field')) {
            return false;
        }

        let url = new URL(location.href);

        let sortFieldName = target.dataset.field;
        let orderValue = 'desc';
        if (url.searchParams.has('sort') && url.searchParams.get('sort') === sortFieldName) {
            orderValue = url.searchParams.get('order') === 'asc' ? 'desc' : 'asc';
        }

        url.searchParams.set('sort', sortFieldName);
        url.searchParams.set('order', orderValue);
        location.replace(url.toString());
    }

}