import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

interface Rental {
    id: number;
    console_name: string;
    customer_name: string;
    start_time: string;
    end_time: string;
    remaining_time: number;
    is_overdue: boolean;
    total_amount: number;
    paid_amount: number;
    payment_status: string;
}

interface Stats {
    available_consoles: number;
    active_rentals: number;
    overdue_rentals: number;
}

interface Props {
    activeRentals: Rental[];
    stats: Stats;
    [key: string]: unknown;
}

export default function CashierDashboard({ activeRentals, stats }: Props) {
    const formatTime = (seconds: number) => {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    };

    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    };

    const getPaymentStatusColor = (status: string) => {
        switch (status) {
            case 'paid':
                return 'text-green-600 bg-green-50 border-green-200';
            case 'partial':
                return 'text-orange-600 bg-orange-50 border-orange-200';
            case 'pending':
                return 'text-red-600 bg-red-50 border-red-200';
            default:
                return 'text-gray-600 bg-gray-50 border-gray-200';
        }
    };

    return (
        <AppShell>
            <div className="space-y-6">
                {/* Header */}
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">🎮 Cashier Dashboard</h1>
                        <p className="text-gray-600 mt-1">Manage rentals and process payments</p>
                    </div>
                    
                    <div className="flex space-x-3">
                        <Link href="/rentals/create">
                            <Button className="bg-blue-600 hover:bg-blue-700">
                                ➕ New Rental
                            </Button>
                        </Link>
                        <Link href="/customers/create">
                            <Button variant="outline">
                                👤 Add Customer
                            </Button>
                        </Link>
                        <Link href="/products">
                            <Button variant="outline">
                                🛒 Sell Products
                            </Button>
                        </Link>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Available Consoles</p>
                                <p className="text-3xl font-bold text-green-600">{stats.available_consoles}</p>
                            </div>
                            <div className="p-3 bg-green-50 rounded-full">
                                <span className="text-2xl">🎯</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active Rentals</p>
                                <p className="text-3xl font-bold text-blue-600">{stats.active_rentals}</p>
                            </div>
                            <div className="p-3 bg-blue-50 rounded-full">
                                <span className="text-2xl">⏰</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Overdue Rentals</p>
                                <p className="text-3xl font-bold text-red-600">{stats.overdue_rentals}</p>
                            </div>
                            <div className="p-3 bg-red-50 rounded-full">
                                <span className="text-2xl">⚠️</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Active Rentals */}
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div className="p-6 border-b border-gray-200">
                        <div className="flex items-center justify-between">
                            <h2 className="text-xl font-semibold text-gray-900">🔥 Active Rentals</h2>
                            <Link href="/rentals">
                                <Button variant="outline" size="sm">
                                    View All
                                </Button>
                            </Link>
                        </div>
                    </div>
                    
                    {activeRentals.length === 0 ? (
                        <div className="p-8 text-center text-gray-500">
                            <span className="text-6xl block mb-4">🎮</span>
                            <p className="text-lg font-medium">No Active Rentals</p>
                            <p className="text-sm">Start a new rental session to get started</p>
                            <Link href="/rentals/create" className="mt-4 inline-block">
                                <Button>Start New Rental</Button>
                            </Link>
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Console & Customer</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Remaining</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {activeRentals.map((rental) => (
                                        <tr key={rental.id} className={rental.is_overdue ? 'bg-red-50' : 'hover:bg-gray-50'}>
                                            <td className="px-6 py-4">
                                                <div>
                                                    <div className="font-medium text-gray-900">🎮 {rental.console_name}</div>
                                                    <div className="text-sm text-gray-500">👤 {rental.customer_name}</div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className={`font-mono text-lg font-bold ${rental.is_overdue ? 'text-red-600' : 'text-green-600'}`}>
                                                    {rental.is_overdue ? '⚠️ OVERDUE' : formatTime(rental.remaining_time)}
                                                </div>
                                                <div className="text-xs text-gray-500">
                                                    Ends at {new Date(rental.end_time).toLocaleTimeString()}
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="text-sm">
                                                    <div className="font-medium">{formatCurrency(rental.paid_amount)} / {formatCurrency(rental.total_amount)}</div>
                                                    <div className={`text-xs px-2 py-1 rounded-full border ${getPaymentStatusColor(rental.payment_status)}`}>
                                                        {rental.payment_status.toUpperCase()}
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <span className={`px-3 py-1 text-xs font-medium rounded-full ${
                                                    rental.is_overdue 
                                                        ? 'bg-red-100 text-red-800' 
                                                        : 'bg-green-100 text-green-800'
                                                }`}>
                                                    {rental.is_overdue ? '⚠️ Overdue' : '✅ Active'}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex space-x-2">
                                                    <Link href={`/rentals/${rental.id}`}>
                                                        <Button size="sm" variant="outline">
                                                            👁️ View
                                                        </Button>
                                                    </Link>
                                                    {rental.payment_status !== 'paid' && (
                                                        <Link href={`/rentals/${rental.id}/edit`}>
                                                            <Button size="sm" className="bg-green-600 hover:bg-green-700">
                                                                💰 Pay
                                                            </Button>
                                                        </Link>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </div>

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Link href="/rentals">
                        <div className="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            <div className="text-2xl mb-2">📋</div>
                            <h3 className="font-semibold text-gray-900">All Rentals</h3>
                            <p className="text-sm text-gray-600">View rental history</p>
                        </div>
                    </Link>

                    <Link href="/customers">
                        <div className="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            <div className="text-2xl mb-2">👥</div>
                            <h3 className="font-semibold text-gray-900">Customers</h3>
                            <p className="text-sm text-gray-600">Manage customer database</p>
                        </div>
                    </Link>

                    <Link href="/products">
                        <div className="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            <div className="text-2xl mb-2">🛒</div>
                            <h3 className="font-semibold text-gray-900">Products</h3>
                            <p className="text-sm text-gray-600">Food & accessories</p>
                        </div>
                    </Link>

                    <div className="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <div className="text-2xl mb-2">💡</div>
                        <h3 className="font-semibold text-gray-900">Quick Tips</h3>
                        <p className="text-sm text-gray-600">Check overdue rentals first</p>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}