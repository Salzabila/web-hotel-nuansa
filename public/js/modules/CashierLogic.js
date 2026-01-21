/**
 * CashierLogic.js
 * Modul untuk CRUD manajemen kasir
 */

define([], function() {
    'use strict';

    // Storage sementara untuk kasir
    var cashiers = [
        'Admin Nuansa',
        'Kasir 1',
        'Kasir 2'
    ];

    /**
     * Ambil semua kasir
     * @returns {Array<string>}
     */
    function getAllCashiers() {
        return cashiers.slice(); // Return copy
    }

    /**
     * Tambah kasir baru
     * @param {string} name - Nama kasir
     * @returns {Object} { success: boolean, message: string, cashiers: Array }
     */
    function addCashier(name) {
        // Validasi
        if (!name || name.trim() === '') {
            return {
                success: false,
                message: 'Nama kasir tidak boleh kosong',
                cashiers: getAllCashiers()
            };
        }

        var trimmedName = name.trim();

        // Cek duplikat
        if (cashiers.indexOf(trimmedName) !== -1) {
            return {
                success: false,
                message: 'Kasir dengan nama "' + trimmedName + '" sudah ada',
                cashiers: getAllCashiers()
            };
        }

        // Tambahkan
        cashiers.push(trimmedName);

        return {
            success: true,
            message: 'Kasir "' + trimmedName + '" berhasil ditambahkan',
            cashiers: getAllCashiers()
        };
    }

    /**
     * Hapus kasir berdasarkan nama
     * @param {string} name - Nama kasir yang akan dihapus
     * @returns {Object} { success: boolean, message: string, cashiers: Array }
     */
    function deleteCashier(name) {
        var index = cashiers.indexOf(name);

        if (index === -1) {
            return {
                success: false,
                message: 'Kasir "' + name + '" tidak ditemukan',
                cashiers: getAllCashiers()
            };
        }

        // Hapus dari array
        cashiers.splice(index, 1);

        return {
            success: true,
            message: 'Kasir "' + name + '" berhasil dihapus',
            cashiers: getAllCashiers()
        };
    }

    /**
     * Cari kasir berdasarkan nama (partial match)
     * @param {string} query
     * @returns {Array<string>}
     */
    function searchCashier(query) {
        if (!query) return getAllCashiers();

        var lowerQuery = query.toLowerCase();
        return cashiers.filter(function(cashier) {
            return cashier.toLowerCase().indexOf(lowerQuery) !== -1;
        });
    }

    /**
     * Reset ke data default
     */
    function resetCashiers() {
        cashiers = [
            'Admin Nuansa',
            'Kasir 1',
            'Kasir 2'
        ];
        return {
            success: true,
            message: 'Data kasir direset ke default',
            cashiers: getAllCashiers()
        };
    }

    // Public API
    return {
        getAll: getAllCashiers,
        add: addCashier,
        delete: deleteCashier,
        search: searchCashier,
        reset: resetCashiers
    };
});
