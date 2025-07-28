document.getElementById('batchWiseOption').addEventListener('click', function() {
    this.classList.toggle('selected');
    document.getElementById('nearbyAllocationOption').classList.remove('selected');
});

document.getElementById('nearbyAllocationOption').addEventListener('click', function() {
    this.classList.toggle('selected');
    document.getElementById('batchWiseOption').classList.remove('selected');
});