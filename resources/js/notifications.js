/**
 * Notification System
 * Handles notification bell, badge, and popup functionality
 */

class NotificationSystem {
    constructor() {
        this.bellButton = document.getElementById('notification-bell');
        this.popup = document.getElementById('notification-popup');
        this.badge = document.getElementById('notification-badge');
        this.notificationList = document.getElementById('notification-list');
        this.markAllReadBtn = document.getElementById('mark-all-read-btn');

        if (!this.bellButton) return; // Not logged in

        this.init();
    }

    init() {
        // Load initial unread count
        this.updateUnreadCount();

        // Poll for updates every 30 seconds
        setInterval(() => this.updateUnreadCount(), 30000);

        // Toggle popup on bell click
        this.bellButton.addEventListener('click', (e) => {
            e.stopPropagation();
            this.togglePopup();
        });

        // Close popup when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('notification-bell-container').contains(e.target)) {
                this.closePopup();
            }
        });

        // Mark all as read button
        this.markAllReadBtn.addEventListener('click', () => {
            this.markAllAsRead();
        });
    }

    async updateUnreadCount() {
        try {
            const response = await fetch('/api/notifications/unread-count', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to fetch');

            const data = await response.json();
            this.updateBadge(data.count);
        } catch (error) {
            console.error('Error fetching unread count:', error);
        }
    }

    updateBadge(count) {
        if (count > 0) {
            this.badge.textContent = count > 99 ? '99+' : count;
            this.badge.classList.remove('hidden');
        } else {
            this.badge.classList.add('hidden');
        }
    }

    async togglePopup() {
        if (this.popup.classList.contains('hidden')) {
            await this.openPopup();
        } else {
            this.closePopup();
        }
    }

    async openPopup() {
        this.popup.classList.remove('hidden');
        await this.loadRecentNotifications();
    }

    closePopup() {
        this.popup.classList.add('hidden');
    }

    async loadRecentNotifications() {
        try {
            this.notificationList.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">Loading...</div>';

            const response = await fetch('/api/notifications/recent', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to fetch');

            const data = await response.json();
            this.renderNotifications(data.notifications);
        } catch (error) {
            console.error('Error loading notifications:', error);
            this.notificationList.innerHTML = '<div class="p-4 text-center text-red-500 text-sm">Failed to load notifications</div>';
        }
    }

    renderNotifications(notifications) {
        if (notifications.length === 0) {
            this.notificationList.innerHTML = `
                <div class="p-8 text-center">
                    <i class="fa-solid fa-bell-slash text-gray-300 text-3xl mb-2"></i>
                    <p class="text-gray-500 text-sm">No notifications</p>
                </div>
            `;
            return;
        }

        const html = notifications.map(notification => {
            const icon = this.getNotificationIcon(notification.type);
            const unreadDot = !notification.is_read ? '<span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>' : '';
            const bgClass = !notification.is_read ? 'bg-blue-50 hover:bg-blue-100' : 'hover:bg-gray-50';

            return `
                <div class="notification-item border-b border-gray-100 p-3 cursor-pointer transition-colors ${bgClass}" data-id="${notification.id}">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5">${icon}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 line-clamp-2">${this.escapeHtml(notification.message)}</p>
                            <p class="text-xs text-gray-500 mt-1">${notification.created_at}</p>
                        </div>
                        ${unreadDot}
                    </div>
                </div>
            `;
        }).join('');

        this.notificationList.innerHTML = html;

        // Add click handlers to notification items
        this.notificationList.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', async () => {
                const notificationId = item.getAttribute('data-id');
                await this.markAsRead(notificationId);
                window.location.href = '/notifications';
            });
        });
    }

    getNotificationIcon(type) {
        const icons = {
            'match': '<i class="fa-solid fa-handshake text-green-500"></i>',
            'update': '<i class="fa-solid fa-sync text-blue-500"></i>',
            'alert': '<i class="fa-solid fa-exclamation-triangle text-yellow-500"></i>',
            'delivery': '<i class="fa-solid fa-truck text-purple-500"></i>',
            'new_donation': '<i class="fa-solid fa-gift text-emerald-500"></i>',
            'new_request': '<i class="fa-solid fa-hand-holding-heart text-pink-500"></i>',
            'new_delivery_task': '<i class="fa-solid fa-truck-fast text-indigo-500"></i>',
            'default': '<i class="fa-solid fa-info-circle text-gray-500"></i>'
        };

        return icons[type] || icons['default'];
    }

    async markAsRead(notificationId) {
        try {
            const response = await fetch(`/api/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to mark as read');

            await this.updateUnreadCount();
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to mark all as read');

            await this.updateUnreadCount();
            await this.loadRecentNotifications();
        } catch (error) {
            console.error('Error marking all as read:', error);
        }
    }

    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
}

// Initialize notification system when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new NotificationSystem();
    });
} else {
    new NotificationSystem();
}