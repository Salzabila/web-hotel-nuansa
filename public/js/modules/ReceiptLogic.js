/**
 * ReceiptLogic.js
 * Modul untuk generate format struk/receipt
 */

define(['modules/ShiftLogic'], function(ShiftLogic) {
    'use strict';

    /**
     * Generate struk text
     * @param {Object} data
     * @param {string} data.hotelName - Nama hotel
     * @param {string} data.roomNumber - Nomor kamar
     * @param {Date} data.checkIn - Waktu check-in
     * @param {Date} data.checkOut - Waktu check-out
     * @param {string} data.cashierName - Nama kasir
     * @param {string} data.guestName - Nama pelanggan
     * @param {number} [data.totalAmount] - Total pembayaran
     * @returns {string} Formatted receipt text
     */
    function generateReceipt(data) {
        // Get shift info dari waktu check-in
        var shiftInfo = ShiftLogic.getCurrentShift(data.checkIn);

        // Format dates
        var checkInFormatted = ShiftLogic.formatDateTime(data.checkIn);
        var checkOutFormatted = ShiftLogic.formatDateTime(data.checkOut);

        // Build receipt string
        var receipt = [];
        receipt.push('═══════════════════════════════════');
        receipt.push('          ' + (data.hotelName || 'NUANSA HOTEL'));
        receipt.push('═══════════════════════════════════');
        receipt.push('');
        receipt.push('Shift        : ' + shiftInfo.shift + ' (' + shiftInfo.period + ')');
        receipt.push('Kamar        : ' + data.roomNumber);
        receipt.push('Pelanggan    : ' + (data.guestName || '-'));
        receipt.push('');
        receipt.push('Check In     : ' + checkInFormatted);
        receipt.push('Check Out    : ' + checkOutFormatted);
        receipt.push('');
        
        if (data.totalAmount) {
            receipt.push('Total        : Rp ' + formatCurrency(data.totalAmount));
            receipt.push('');
        }

        receipt.push('Kasir        : ' + data.cashierName);
        receipt.push('');
        receipt.push('═══════════════════════════════════');
        receipt.push('        TERIMA KASIH');
        receipt.push('═══════════════════════════════════');
        receipt.push('');
        receipt.push('Dicetak pada: ' + ShiftLogic.formatDateTime(new Date()));

        return receipt.join('\n');
    }

    /**
     * Generate HTML receipt untuk print
     * @param {Object} data - Data yang sama dengan generateReceipt
     * @returns {string} HTML string
     */
    function generateReceiptHTML(data) {
        var shiftInfo = ShiftLogic.getCurrentShift(data.checkIn);
        var checkInFormatted = ShiftLogic.formatDateTime(data.checkIn);
        var checkOutFormatted = ShiftLogic.formatDateTime(data.checkOut);

        var html = '<div class="receipt" style="font-family: monospace; width: 300px; margin: 0 auto; padding: 20px; border: 2px solid #333;">';
        html += '<h2 style="text-align: center; margin: 10px 0;">' + (data.hotelName || 'NUANSA HOTEL') + '</h2>';
        html += '<hr>';
        html += '<table style="width: 100%; font-size: 14px;">';
        html += '<tr><td><strong>Shift</strong></td><td>: ' + shiftInfo.shift + ' (' + shiftInfo.period + ')</td></tr>';
        html += '<tr><td><strong>Kamar</strong></td><td>: ' + data.roomNumber + '</td></tr>';
        html += '<tr><td><strong>Pelanggan</strong></td><td>: ' + (data.guestName || '-') + '</td></tr>';
        html += '<tr><td colspan="2">&nbsp;</td></tr>';
        html += '<tr><td><strong>Check In</strong></td><td>: ' + checkInFormatted + '</td></tr>';
        html += '<tr><td><strong>Check Out</strong></td><td>: ' + checkOutFormatted + '</td></tr>';
        
        if (data.totalAmount) {
            html += '<tr><td colspan="2">&nbsp;</td></tr>';
            html += '<tr><td><strong>Total</strong></td><td>: Rp ' + formatCurrency(data.totalAmount) + '</td></tr>';
        }

        html += '<tr><td colspan="2">&nbsp;</td></tr>';
        html += '<tr><td><strong>Kasir</strong></td><td>: ' + data.cashierName + '</td></tr>';
        html += '</table>';
        html += '<hr>';
        html += '<p style="text-align: center; margin: 10px 0;"><strong>TERIMA KASIH</strong></p>';
        html += '<p style="text-align: center; font-size: 11px;">Dicetak: ' + ShiftLogic.formatDateTime(new Date()) + '</p>';
        html += '</div>';

        return html;
    }

    /**
     * Format number ke currency Indonesia
     * @param {number} amount
     * @returns {string}
     */
    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    /**
     * Validate data sebelum generate receipt
     * @param {Object} data
     * @returns {Object} { valid: boolean, errors: Array<string> }
     */
    function validateReceiptData(data) {
        var errors = [];

        if (!data.roomNumber) {
            errors.push('Nomor kamar harus diisi');
        }

        if (!data.checkIn || !(data.checkIn instanceof Date)) {
            errors.push('Tanggal check-in tidak valid');
        }

        if (!data.checkOut || !(data.checkOut instanceof Date)) {
            errors.push('Tanggal check-out tidak valid');
        }

        if (!data.cashierName || data.cashierName.trim() === '') {
            errors.push('Nama kasir harus dipilih');
        }

        if (data.checkIn && data.checkOut && data.checkIn >= data.checkOut) {
            errors.push('Check-out harus lebih besar dari check-in');
        }

        return {
            valid: errors.length === 0,
            errors: errors
        };
    }

    // Public API
    return {
        generate: generateReceipt,
        generateHTML: generateReceiptHTML,
        validate: validateReceiptData,
        formatCurrency: formatCurrency
    };
});
