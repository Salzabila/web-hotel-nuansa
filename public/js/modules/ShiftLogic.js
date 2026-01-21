/**
 * ShiftLogic.js
 * Modul untuk manajemen shift kerja (Pagi/Malam)
 */

define([], function() {
    'use strict';

    /**
     * Cek shift berdasarkan waktu sistem
     * @param {Date} [currentTime] - Waktu untuk dicek (default: new Date())
     * @returns {Object} { shift: 'Pagi'|'Malam', time: 'HH:MM', period: '07:30 - 19:30' }
     */
    function getCurrentShift(currentTime) {
        const now = currentTime || new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const timeString = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');

        // Shift Pagi: 07:30 - 19:30
        // Shift Malam: 19:30 - 07:30 (next day)
        let shift, period;

        if (hours > 7 && hours < 19) {
            // Antara jam 8-18 pasti Pagi
            shift = 'Pagi';
            period = '07:30 - 19:30';
        } else if (hours === 7) {
            // Jam 7, cek menit
            shift = minutes >= 30 ? 'Pagi' : 'Malam';
            period = shift === 'Pagi' ? '07:30 - 19:30' : '19:30 - 07:30';
        } else if (hours === 19) {
            // Jam 19, cek menit
            shift = minutes < 30 ? 'Pagi' : 'Malam';
            period = shift === 'Pagi' ? '07:30 - 19:30' : '19:30 - 07:30';
        } else {
            // Jam 20-23 atau 0-6 = Malam
            shift = 'Malam';
            period = '19:30 - 07:30';
        }

        return {
            shift: shift,
            time: timeString,
            period: period,
            date: now
        };
    }

    /**
     * Format waktu untuk display
     * @param {Date} date
     * @returns {string} Format: YYYY-MM-DD (HH:MM)
     */
    function formatDateTime(date) {
        if (!(date instanceof Date)) {
            date = new Date(date);
        }

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return year + '-' + month + '-' + day + ' (' + hours + ':' + minutes + ')';
    }

    /**
     * Get time only (HH:MM) dalam kurung
     * @param {Date} date
     * @returns {string} Format: (HH:MM)
     */
    function formatTimeOnly(date) {
        if (!(date instanceof Date)) {
            date = new Date(date);
        }

        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return '(' + hours + ':' + minutes + ')';
    }

    // Public API
    return {
        getCurrentShift: getCurrentShift,
        formatDateTime: formatDateTime,
        formatTimeOnly: formatTimeOnly
    };
});
