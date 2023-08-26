window.onload = function () {
    // prevent form resubmition on refresh
    window.history.pushState({}, '', '');

    // loop through all tooltip selectors and activate them
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // loop through all delete room buttons and
    // attach a click event listener.
    // once clicked, confirm with the user and prevent default if they're kidding ;)
    const deleteButtonsList = [].slice.call(document.querySelectorAll('.delete-room'));
    const deleteList = deleteButtonsList.map(function (item) {
        item.addEventListener('click', function (event) {
            if (!confirm('Are you sure you want to delete this room?')) {
                event.preventDefault();
            }
        });
    });

    const newRoom = document.getElementById('newRoom');

    // fill modal with event values so that we will know
    // if we should update a room or create a new one
    newRoom.addEventListener('show.bs.modal', function (event) {
        const data = event.relatedTarget.dataset;
        const formAction = document.getElementById('formAction');

        formAction.value = data.action;

        if (data.action == 'edit') {
            document.getElementById('roomID').value = data.id;
            document.getElementById('roomName').value = data.name;
            document.getElementById('roomPrice').value = data.cost;
            document.getElementById('roomDescription').value = data.details;
            document.getElementById('roomBooked').checked = data.booked == '1';
        }
    });

    // reset values after the modal has closed
    newRoom.addEventListener('hidden.bs.modal', function () {
        document.getElementById('roomID').value = '';
        document.getElementById('roomName').value = '';
        document.getElementById('roomPrice').value = '';
        document.getElementById('roomDescription').value = '';
        document.getElementById('formAction').value = '';
        document.getElementById('roomAvailable').checked = false;
    });
};
