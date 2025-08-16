import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
            {/* Header */}
            <header className="p-6">
                <nav className="flex justify-between items-center max-w-7xl mx-auto">
                    <div className="flex items-center space-x-2">
                        <div className="bg-blue-600 rounded-lg p-2">
                            <svg className="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900">🎮 GameZone Pro</h1>
                            <p className="text-sm text-gray-600">Smart PS Rental Management</p>
                        </div>
                    </div>
                    
                    <div className="flex space-x-4">
                        <Link href="/login">
                            <Button variant="outline" className="border-blue-200 text-blue-700 hover:bg-blue-50">
                                🔐 Login
                            </Button>
                        </Link>
                        <Link href="/register">
                            <Button className="bg-blue-600 hover:bg-blue-700 text-white">
                                📋 Register
                            </Button>
                        </Link>
                    </div>
                </nav>
            </header>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-6 py-16">
                <div className="text-center mb-16">
                    <div className="mb-8">
                        <span className="text-6xl">🎮</span>
                    </div>
                    <h1 className="text-5xl font-bold text-gray-900 mb-6">
                        Complete PS Rental Management
                        <span className="text-blue-600"> with IoT Control</span>
                    </h1>
                    <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Manage PlayStation console rentals with real-time monitoring, automated device control, 
                        fraud detection, and comprehensive reporting. Perfect for gaming cafes and rental businesses.
                    </p>
                    
                    <div className="flex justify-center space-x-4">
                        <Link href="/login">
                            <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 text-lg">
                                🚀 Start Managing
                            </Button>
                        </Link>
                        <Button variant="outline" size="lg" className="border-gray-300 text-gray-700 px-8 py-3 text-lg">
                            📖 View Demo
                        </Button>
                    </div>
                </div>

                {/* Features Grid */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">💳</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">Cashier Dashboard</h3>
                        <p className="text-gray-600 mb-4">
                            Complete rental management with timer control, payment processing, and product sales integration.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Start/stop rental sessions</li>
                            <li>• Process payments & sales</li>
                            <li>• Real-time timer monitoring</li>
                            <li>• Customer management</li>
                        </ul>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">📊</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">Admin Analytics</h3>
                        <p className="text-gray-600 mb-4">
                            Comprehensive reporting with revenue tracking, device monitoring, and exportable reports.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Revenue & sales analytics</li>
                            <li>• Device performance metrics</li>
                            <li>• Exportable PDF/Excel reports</li>
                            <li>• Fraud detection alerts</li>
                        </ul>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">🔌</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">IoT Device Control</h3>
                        <p className="text-gray-600 mb-4">
                            Automated PlayStation control with remote power management and anti-tampering security.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Automatic power on/off</li>
                            <li>• Real-time device status</li>
                            <li>• Tampering detection</li>
                            <li>• Remote troubleshooting</li>
                        </ul>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">⚡</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">Real-time Updates</h3>
                        <p className="text-gray-600 mb-4">
                            WebSocket-powered live updates for rental timers, device status, and system notifications.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Live rental timers</li>
                            <li>• Instant notifications</li>
                            <li>• Multi-user synchronization</li>
                            <li>• Auto-refresh dashboards</li>
                        </ul>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">🛡️</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">Fraud Prevention</h3>
                        <p className="text-gray-600 mb-4">
                            Advanced security with unauthorized access detection, power manipulation alerts, and audit trails.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Unauthorized access detection</li>
                            <li>• Power manipulation alerts</li>
                            <li>• Complete audit logging</li>
                            <li>• Automated security responses</li>
                        </ul>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                        <div className="text-3xl mb-4">🐳</div>
                        <h3 className="text-xl font-semibold mb-3 text-gray-900">Easy Deployment</h3>
                        <p className="text-gray-600 mb-4">
                            Docker-ready deployment with complete documentation and database migrations included.
                        </p>
                        <ul className="text-sm text-gray-500 space-y-1">
                            <li>• Docker containerization</li>
                            <li>• One-click deployment</li>
                            <li>• Complete documentation</li>
                            <li>• Environment configuration</li>
                        </ul>
                    </div>
                </div>

                {/* Stats Section */}
                <div className="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 mb-16">
                    <div className="text-center mb-8">
                        <h2 className="text-3xl font-bold text-gray-900 mb-4">
                            🏆 Built for Gaming Business Success
                        </h2>
                        <p className="text-gray-600 max-w-2xl mx-auto">
                            Everything you need to run a profitable PS rental business with complete automation and control.
                        </p>
                    </div>
                    
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="text-3xl font-bold text-blue-600">24/7</div>
                            <div className="text-gray-600">Automated Monitoring</div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-green-600">100%</div>
                            <div className="text-gray-600">Device Control</div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-purple-600">Real-time</div>
                            <div className="text-gray-600">Fraud Detection</div>
                        </div>
                        <div className="text-center">
                            <div className="text-3xl font-bold text-orange-600">Multi-user</div>
                            <div className="text-gray-600">Dashboard Access</div>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="text-center bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-12 text-white">
                    <h2 className="text-3xl font-bold mb-4">
                        Ready to Revolutionize Your Gaming Business? 🎯
                    </h2>
                    <p className="text-xl mb-8 opacity-90">
                        Join the future of automated PS rental management with IoT integration.
                    </p>
                    
                    <div className="flex justify-center space-x-4">
                        <Link href="/register">
                            <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 text-lg font-semibold">
                                🚀 Get Started Free
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button variant="outline" size="lg" className="border-white text-white hover:bg-white hover:text-blue-600 px-8 py-3 text-lg font-semibold">
                                🔐 Admin Login
                            </Button>
                        </Link>
                    </div>
                </div>
            </main>

            {/* Footer */}
            <footer className="border-t border-gray-200 py-8">
                <div className="max-w-7xl mx-auto px-6 text-center text-gray-600">
                    <p>© 2024 GameZone Pro. Professional PS rental management with IoT automation.</p>
                </div>
            </footer>
        </div>
    );
}