/**
 * UIController.js
 * Modul untuk manipulasi DOM dan interaksi UI
 */

define(['modules/CashierLogic', 'modules/ShiftLogic'], function(CashierLogic, ShiftLogic) {
    'use strict';

    // DOM References (akan diinit saat ready)
    var elements = {};

    /**
     * Initialize DOM references
     */
    function initElements() {
        elements = {
            // Cashier Management
            cashierInput: document.getElementById('cashierInput'),
            btnAddCashier: document.getElementById('btnAddCashier'),
            cashierList: document.getElementById('cashierList'),
            cashierMessage: document.getElementById('cashierMessage'),

            // Checkout Form
            cashierSelect: document.getElementById('cashierSelect'),
            roomNumber: document.getElementById('roomNumber'),
            guestName: document.getElementById('guestName'),
            checkInDate: document.getElementById('checkInDate'),
            checkInTime: document.getElementById('checkInTime'),
            checkOutDate: document.getElementById('checkOutDate'),
            checkOutTime: document.getElementById('checkOutTime'),
            totalAmount: document.getElementById('totalAmount'),
            btnPrintReceipt: document.getElementById('btnPrintReceipt'),

            // Display
            currentShift: document.getElementById('currentShift'),
            receiptPreview: document.getElementById('receiptPreview')
        };
    }

    /**
     * Update dropdown kasir
     */
    function updateCashierSelect() {
        var cashiers = CashierLogic.getAll();
        var select = elements.cashierSelect;

        if (!select) return;

        // Clear existing options
        select.innerHTML = '<option value="">-- Pilih Kasir --</option>';

        // Add cashiers
        cashiers.forEach(function(cashier) {
            var option = document.createElement('option');
            option.value = cashier;
            option.textContent = cashier;
            select.appendChild(option);
        });
    }

    /**
     * Update list kasir di manajemen
     */
    function updateCashierList() {
        var cashiers = CashierLogic.getAll();
        var listContainer = elements.cashierList;

        if (!listContainer) return;

        // Clear list
        listContainer.innerHTML = '';

        if (cashiers.length === 0) {
            listContainer.innerHTML = '<li class="list-group-item text-muted">Tidak ada kasir</li>';
            return;
        }

        // Build list
        cashiers.forEach(function(cashier) {
            var li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = cashier + 
                '<button class="btn btn-sm btn-danger btn-delete-cashier" data-name="' + cashier + '">Hapus</button>';
            listContainer.appendChild(li);
        });

        // Attach delete handlers
        var deleteButtons = listContainer.querySelectorAll('.btn-delete-cashier');
        deleteButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var name = this.getAttribute('data-name');
                handleDeleteCashier(name);
            });
        });
    }

    /**
     * Handle add kasir
     */
    function handleAddCashier() {
        var input = elements.cashierInput;
        var name = input.value;

        var result = CashierLogic.add(name);

        showMessage(result.message, result.success ? 'success' : 'danger');

        if (result.success) {
            input.value = ''; // Clear input
            updateCashierList();
            updateCashierSelect();
        }
    }

    /**
     * Handle delete kasir
     */
    function handleDeleteCashier(name) {
        if (!confirm('Hapus kasir "' + name + '"?')) {
            return;
        }

        var result = CashierLogic.delete(name);

        showMessage(result.message, result.success ? 'success' : 'danger');

        if (result.success) {
            updateCashierList();
            updateCashierSelect();
        }
    }

    /**
     * Show message
     */
    function showMessage(message, type) {
        var messageDiv = elements.cashierMessage;
        if (!messageDiv) return;

        messageDiv.className = 'alert alert-' + type;
        messageDiv.textContent = message;
        messageDiv.style.display = 'block';

        // Auto hide after 3 seconds
        setTimeout(function() {
            messageDiv.style.display = 'none';
        }, 3000);
    }

    /**
     * Update shift display
     */
    function updateShiftDisplay() {
        var shiftInfo = ShiftLogic.getCurrentShift();
        var display = elements.currentShift;

        if (!display) return;

        display.innerHTML = '<strong>Shift Saat Ini:</strong> ' + 
            shiftInfo.shift + ' (' + shiftInfo.period + ') | ' +
            '<strong>Waktu:</strong> ' + shiftInfo.time;
    }

    /**
     * Get form data untuk checkout
     */
    function getCheckoutData() {
        return {
            hotelName: 'NUANSA HOTEL',
            roomNumber: elements.roomNumber.value,
            guestName: elements.guestName.value,
            checkIn: new Date(elements.checkInDate.value + 'T' + elements.checkInTime.value),
            checkOut: new Date(elements.checkOutDate.value + 'T' + elements.checkOutTime.value),
            cashierName: elements.cashierSelect.value,
            totalAmount: parseFloat(elements.totalAmount.value) || 0
        };
    }

    /**
     * Clear checkout form
     */
    function clearCheckoutForm() {
        elements.roomNumber.value = '';
        elements.guestName.value = '';
        elements.checkInDate.value = '';
        elements.checkInTime.value = '';
        elements.checkOutDate.value = '';
        elements.checkOutTime.value = '';
        elements.totalAmount.value = '';
        elements.cashierSelect.value = '';
    }

    /**
     * Set default date time (untuk demo)
     */
    function setDefaultDateTime() {
        var now = new Date();
        var dateStr = now.getFullYear() + '-' + 
            String(now.getMonth() + 1).padStart(2, '0') + '-' + 
            String(now.getDate()).padStart(2, '0');
        var timeStr = String(now.getHours()).padStart(2, '0') + ':' + 
            String(now.getMinutes()).padStart(2, '0');

        if (elements.checkInDate) elements.checkInDate.value = dateStr;
        if (elements.checkInTime) elements.checkInTime.value = timeStr;
    }

    /**
     * Bind all events
     */
    function bindEvents() {
        // Add cashier button
        if (elements.btnAddCashier) {
            elements.btnAddCashier.addEventListener('click', handleAddCashier);
        }

        // Add cashier on Enter key
        if (elements.cashierInput) {
            elements.cashierInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    handleAddCashier();
                }
            });
        }

        // Print receipt button (will be handled by main.js)
        // Just expose getter
    }

    /**
     * Initialize UI
     */
    function init() {
        initElements();
        updateCashierList();
        updateCashierSelect();
        updateShiftDisplay();
        setDefaultDateTime();
        bindEvents();

        // Update shift setiap 1 menit
        setInterval(updateShiftDisplay, 60000);
    }

    // Public API
    return {
        init: init,
        updateCashierList: updateCashierList,
        updateCashierSelect: updateCashierSelect,
        updateShiftDisplay: updateShiftDisplay,
        getCheckoutData: getCheckoutData,
        clearCheckoutForm: clearCheckoutForm,
        showMessage: showMessage,
        getElements: function() { return elements; }
    };
});
