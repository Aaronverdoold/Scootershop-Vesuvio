(async function() {
    const statusEl = document.getElementById('status');
    const container = document.getElementById('table-container');
    const endpoint = '../../backend/Presentation/orders/OrdersView.php';

    try {
        const res = await fetch(endpoint);
        if (!res.ok) {
            const text = await res.text();
            statusEl.className = 'error';
            statusEl.textContent = 'Server error: ' + res.status + ' - ' + res.statusText + (text ? ' (' + text + ')' : '');
            return;
        }

        const data = await res.json();
        if (!data.ok) {
            statusEl.className = 'error';
            statusEl.textContent = 'Error loading orders: ' + (data.error || 'unknown error');
            return;
        }

        const orders = data.orders || [];
        if (orders.length === 0) {
            statusEl.textContent = '';
            container.innerHTML = '<p class="no-data">No orders found.</p>';
            return;
        }

        statusEl.textContent = '';

        const table = document.createElement('table');
        const thead = document.createElement('thead');
        thead.innerHTML = '<tr>' +
            '<th>Order ID</th>' +
            '<th>Date</th>' +
            '<th>Recipient / Company</th>' +
            '<th>Address</th>' +
            '<th>Country</th>' +
            '<th>Status</th>' +
            '<th>Part ID</th>' +
            '<th>Part</th>' +
            '<th>Price</th>' +
            '<th>Packed</th>' +
            '</tr>';
        table.appendChild(thead);

        const tbody = document.createElement('tbody');

        orders.forEach(order => {
            const parts = order.parts || [];
            if (parts.length === 0) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td>' + escapeHtml(order.id) + '</td>' +
                    '<td>' + escapeHtml(order.date) + '</td>' +
                    '<td>' + escapeHtml(order.company_name || order.recipient || '') + '</td>' +
                    '<td>' + escapeHtml((order.addressline1 || '') + ' ' + (order.addressline2 || '')) + '</td>' +
                    '<td>' + escapeHtml(order.country || '') + '</td>' +
                    '<td>' + escapeHtml(order.status || '') + '</td>' +
                    '<td class="no-data" colspan="4">No parts for this order</td>';
                tbody.appendChild(tr);
                return;
            }

            parts.forEach((part, idx) => {
                const tr = document.createElement('tr');

                if (idx === 0) {
                    const rowspan = parts.length;
                    addCell(tr, escapeHtml(order.id), { rowSpan: rowspan });
                    addCell(tr, escapeHtml(order.date), { rowSpan: rowspan });
                    addCell(tr, escapeHtml(order.company_name || order.recipient || ''), { rowSpan: rowspan });
                    addCell(tr, escapeHtml((order.addressline1 || '') + ' ' + (order.addressline2 || '')), { rowSpan: rowspan });
                    addCell(tr, escapeHtml(order.country || ''), { rowSpan: rowspan });
                    addCell(tr, escapeHtml(order.status || ''), { rowSpan: rowspan });
                }

                addCell(tr, escapeHtml(part.id));
                addCell(tr, escapeHtml(part.part || ''));
                addCell(tr, escapeHtml(part.sell_price || ''));
                addCell(tr, escapeHtml(part.packed ? 'Yes' : 'No'));

                tbody.appendChild(tr);
            });
        });

        table.appendChild(tbody);
        container.innerHTML = '';
        container.appendChild(table);

    } catch (err) {
        statusEl.className = 'error';
        statusEl.textContent = 'Network or parsing error: ' + (err.message || err);
    }

    function addCell(tr, html, opts) {
        const td = document.createElement('td');
        if (opts && opts.rowSpan) td.rowSpan = opts.rowSpan;
        td.innerHTML = html;
        tr.appendChild(td);
    }

    function escapeHtml(value) {
        if (value === null || value === undefined) return '';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
})();

