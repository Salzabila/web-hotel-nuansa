/**
 * main.js
 * Entry point untuk Hotel POS System
 * Menggunakan RequireJS (AMD Pattern)
 */

// Configure RequireJS
requirejs.config({
    baseUrl: 'js',
    paths: {
        'modules': 'modules'
    }
});

// Load main modules
require([
    'modules/ShiftLogic',
    'modules/CashierLogic',
    'modules/ReceiptLogic',
    'modules/UIController'
], function(ShiftLogic, CashierLogic, ReceiptLogic, UIController) {
    'use strict';

    console.log('Hotel POS System - AMD Pattern');
    console.log('═══════════════════════════════════════════');

    /**
     * Initialize application
     */
    function initApp() {
        // Initialize UI
        UIController.init();

        // Bind print receipt button
        var elements = UIController.getElements();
        var btnPrint = elements.btnPrintReceipt;

        if (btnPrint) {
            btnPrint.addEventListener('click', handlePrintReceipt);
        }

        // Show welcome message
        console.log('✅ Application initialized successfully');
        console.log('Current Shift:', ShiftLogic.getCurrentShift());
    }

    /**
     * Handle print receipt
     */
    function handlePrintReceipt() {
        // Get form data
        var data = UIController.getCheckoutData();

        // Validate
        var validation = ReceiptLogic.validate(data);

        if (!validation.valid) {
            alert('Error:\n' + validation.errors.join('\n'));
            return;
        }

        // Generate receipt
        var receiptText = ReceiptLogic.generate(data);
        var receiptHTML = ReceiptLogic.generateHTML(data);

        // Show in preview
        var elements = UIController.getElements();
        if (elements.receiptPreview) {
            elements.receiptPreview.innerHTML = '<pre>' + receiptText + '</pre>';
        }

        // Print in new window
        var printWindow = window.open('', '_blank', 'width=400,height=600');
        printWindow.document.write('<html><head><title>Struk - ' + data.roomNumber + '</title>');
        printWindow.document.write('<style>body { font-family: monospace; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(receiptHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Auto print
        setTimeout(function() {
            printWindow.print();
        }, 500);

        // Show success message
        UIController.showMessage('Struk berhasil dicetak untuk kamar ' + data.roomNumber, 'success');

        // Optional: Clear form after print
        // UIController.clearCheckoutForm();
    }

    /**
     * Demo function untuk testing
     */
    function runDemo() {
        console.log('\n=== DEMO MODE ===\n');

        // Test Shift Logic
        console.log('1. SHIFT LOGIC TEST:');
        var shift = ShiftLogic.getCurrentShift();
        console.log('   Current Shift:', shift);

        // Test morning shift
        var morningTime = new Date();
        morningTime.setHours(10, 30, 0);
        console.log('   Morning (10:30):', ShiftLogic.getCurrentShift(morningTime));

        // Test night shift
        var nightTime = new Date();
        nightTime.setHours(22, 0, 0);
        console.log('   Night (22:00):', ShiftLogic.getCurrentShift(nightTime));

        // Test Cashier Logic
        console.log('\n2. CASHIER LOGIC TEST:');
        console.log('   All Cashiers:', CashierLogic.getAll());
        
        var addResult = CashierLogic.add('Demo Kasir');
        console.log('   Add Result:', addResult);

        // Test Receipt Logic
        console.log('\n3. RECEIPT LOGIC TEST:');
        var sampleData = {
            hotelName: 'NUANSA HOTEL',
            roomNumber: '101',
            guestName: 'Budi Santoso',
            checkIn: new Date(),
            checkOut: new Date(Date.now() + 86400000), // +1 day
            cashierName: 'Admin Nuansa',
            totalAmount: 250000
        };

        var validation = ReceiptLogic.validate(sampleData);
        console.log('   Validation:', validation);

        if (validation.valid) {
            var receipt = ReceiptLogic.generate(sampleData);
            console.log('\n   Generated Receipt:\n' + receipt);
        }

        console.log('\n=== END DEMO ===\n');
    }

    // DOM Ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initApp);
    } else {
        initApp();
    }

    // Expose demo function to global for testing
    window.HotelPOS = {
        demo: runDemo,
        ShiftLogic: ShiftLogic,
        CashierLogic: CashierLogic,
        ReceiptLogic: ReceiptLogic,
        UIController: UIController
    };

    // Auto-run demo in console
    runDemo();
});
