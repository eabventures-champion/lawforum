{{-- ====== IN-PAGE / CONTENT READER SEARCH SYSTEM ====== --}}
<style>
    /* Navigation Search Bar */
    .content-nav-search {
        flex: 1;
        max-width: 480px;
        position: relative;
    }

    .content-nav-search-input {
        width: 100%;
        padding: 9px 125px 9px 38px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 14px;
        font-family: var(--font-ui);
        outline: none;
        transition: var(--transition);
    }

    .content-nav-search-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
        background: rgba(255, 255, 255, 0.08);
    }

    .content-nav-search-input::placeholder {
        color: var(--text-muted);
    }

    .content-nav-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 13px;
        pointer-events: none;
        z-index: 2;
    }

    /* In-Page Match Tools */
    .content-search-tools {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: rgba(12, 18, 32, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        padding: 2px 4px;
        z-index: 5;
        backdrop-filter: blur(8px);
    }

    .content-search-count {
        font-size: 11px;
        font-weight: 700;
        color: var(--gold);
        padding: 0 4px;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
        user-select: none;
    }

    .content-search-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: transparent;
        border: none;
        border-radius: 4px;
        color: #94a3b8;
        cursor: pointer;
        font-size: 10px;
        transition: all 0.15s ease;
        padding: 0;
    }

    .content-search-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .content-search-clear:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    /* Search Results Dropdown */
    .content-search-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #0b1120;
        border: 1px solid rgba(59, 130, 246, 0.35);
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.75), 0 0 24px rgba(59, 130, 246, 0.18);
        z-index: 1000;
        overflow: hidden;
        max-height: 420px;
        display: flex;
        flex-direction: column;
        animation: fadeIn 0.2s ease;
    }

    .dropdown-header {
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-results {
        overflow-y: auto;
        max-height: 300px;
    }

    .dropdown-item {
        display: block;
        padding: 11px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        text-decoration: none !important;
        transition: background 0.15s ease;
        text-align: left;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background: rgba(59, 130, 246, 0.12);
    }

    .dropdown-item-badge {
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 4px;
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.25);
        color: var(--accent-light);
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 4px;
    }

    .dropdown-item-title {
        font-size: 13px;
        font-weight: 700;
        color: #f1f5f9;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-item-subtitle {
        font-size: 12px;
        color: var(--accent-light);
        margin-bottom: 4px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-item-snippet {
        font-size: 11.5px;
        color: #94a3b8;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dropdown-item-snippet mark {
        background: rgba(245, 158, 11, 0.25);
        color: #f59e0b;
        font-weight: 700;
        border-radius: 2px;
        padding: 0 2px;
    }

    .dropdown-footer {
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.03);
        border-top: 1px solid var(--border-color);
        text-align: center;
    }

    .view-all-link {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--accent-light);
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.15s ease;
    }

    .view-all-link:hover {
        color: #93c5fd;
        text-decoration: underline !important;
    }

    /* In-Page Highlights */
    mark.search-highlight {
        background: rgba(245, 158, 11, 0.22);
        color: #f59e0b;
        padding: 2px 4px;
        border-radius: 4px;
        border: 1px solid rgba(245, 158, 11, 0.35);
        display: inline;
        transition: all 0.2s ease;
    }

    mark.search-highlight.active-highlight {
        background: #f59e0b !important;
        color: #060a13 !important;
        font-weight: 700 !important;
        box-shadow: 0 0 16px rgba(245, 158, 11, 0.6) !important;
        border-color: #fbbf24 !important;
        border-radius: 4px !important;
    }
</style>

<script>
(function() {
    let activeMarkIndex = 0;
    let marks = [];
    let currentQuery = '';
    let searchDebounceTimer = null;
    let ajaxAbortController = null;

    const input = document.getElementById('contentSearchInput');
    const tools = document.getElementById('contentSearchTools');
    const countEl = document.getElementById('contentSearchCount');
    const prevBtn = document.getElementById('contentSearchPrev');
    const nextBtn = document.getElementById('contentSearchNext');
    const clearBtn = document.getElementById('contentSearchClear');
    const dropdown = document.getElementById('contentSearchDropdown');
    const sectionMatchesEl = document.getElementById('dropdownSectionMatches');
    const dropdownResultsEl = document.getElementById('dropdownResults');
    const dropdownFooterEl = document.getElementById('dropdownFooter');
    const viewAllLink = document.getElementById('viewAllResultsLink');

    // Get current section ID from container
    const articleContainer = document.querySelector('.premium-article-container');
    const currentSectionId = articleContainer ? articleContainer.getAttribute('data-sid') : null;

    // Clear all existing <mark class="search-highlight">
    function clearHighlights() {
        const contentContainer = document.querySelector('.content');
        if (!contentContainer) return;
        const existingMarks = contentContainer.querySelectorAll('.search-highlight');
        existingMarks.forEach(mark => {
            const parent = mark.parentNode;
            if (parent) {
                const textNode = document.createTextNode(mark.textContent);
                parent.replaceChild(textNode, mark);
                parent.normalize();
            }
        });
        marks = [];
        activeMarkIndex = 0;
    }

    // Highlight matches in current section
    function highlightMatches(word) {
        clearHighlights();
        if (!word) return [];

        const contentContainer = document.querySelector('.content');
        if (!contentContainer) return [];

        const cleanWord = word.trim();
        if (!cleanWord) return [];

        const escapedWord = cleanWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        const regexPattern = escapedWord.replace(/(\\-| )/g, '[ \\-]');
        const regex = new RegExp(`(${regexPattern})`, 'gi');

        const walk = document.createTreeWalker(contentContainer, NodeFilter.SHOW_TEXT, null, false);
        let node;
        const textNodes = [];

        while (node = walk.nextNode()) {
            textNodes.push(node);
        }

        textNodes.forEach(textNode => {
            const parent = textNode.parentNode;
            if (parent) {
                const tagName = parent.tagName.toUpperCase();
                if (tagName !== 'SCRIPT' &&
                    tagName !== 'STYLE' &&
                    tagName !== 'NOSCRIPT' &&
                    tagName !== 'IFRAME' &&
                    tagName !== 'TEXTAREA' &&
                    tagName !== 'MARK' &&
                    !parent.classList.contains('search-highlight')) {

                    const text = textNode.nodeValue;
                    const newHTML = text.replace(regex, '<mark class="search-highlight">$1</mark>');

                    if (newHTML !== text) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = newHTML;

                        while (tempDiv.firstChild) {
                            parent.insertBefore(tempDiv.firstChild, textNode);
                        }
                        parent.removeChild(textNode);
                    }
                }
            }
        });

        marks = Array.from(contentContainer.querySelectorAll('.search-highlight'));
        return marks;
    }

    // Update the active highlighted mark and scroll it into view
    function updateActiveMark(index) {
        if (!marks.length) return;

        marks.forEach(m => m.classList.remove('active-highlight'));

        if (marks[index]) {
            marks[index].classList.add('active-highlight');
            marks[index].scrollIntoView({
                behavior: 'smooth',
                block: 'center',
                inline: 'nearest'
            });

            if (countEl) {
                countEl.textContent = (index + 1) + ' of ' + marks.length;
            }
        }
    }

    // Perform in-page search
    window.performInPageSearch = function(query, triggerDropdown) {
        currentQuery = query ? query.trim() : '';

        if (!currentQuery) {
            clearHighlights();
            if (tools) tools.style.display = 'none';
            if (dropdown) dropdown.style.display = 'none';
            // Update URL
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.pathname);
            }
            return;
        }

        const foundMarks = highlightMatches(currentQuery);

        if (foundMarks.length > 0) {
            if (tools) tools.style.display = 'inline-flex';
            activeMarkIndex = 0;
            updateActiveMark(0);

            // Update URL without reloading
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.pathname + '?search_text=' + encodeURIComponent(currentQuery));
            }

            // Update "Back to Search Results" link if present
            const backLink = document.querySelector('.content-back-search');
            if (backLink) {
                backLink.href = '/main_home_search?search_text=' + encodeURIComponent(currentQuery);
            }

            if (sectionMatchesEl) {
                sectionMatchesEl.innerHTML = '<i class="fa-solid fa-circle-check" style="color: var(--emerald);"></i> ' +
                    foundMarks.length + ' match' + (foundMarks.length > 1 ? 'es' : '') + ' in this section';
            }
        } else {
            if (tools) tools.style.display = 'inline-flex';
            if (countEl) countEl.textContent = '0 matches';

            if (sectionMatchesEl) {
                sectionMatchesEl.innerHTML = '<i class="fa-solid fa-circle-info" style="color: var(--gold);"></i> 0 matches in this section';
            }
        }

        if (triggerDropdown && currentQuery) {
            fetchOtherResults(currentQuery, foundMarks.length);
        }
    };

    // Fetch matching sections across other laws via AJAX
    function fetchOtherResults(query, sectionMatchCount) {
        if (ajaxAbortController) {
            ajaxAbortController.abort();
        }
        ajaxAbortController = new AbortController();

        fetch('/main_home_search?search_text=' + encodeURIComponent(query), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            signal: ajaxAbortController.signal
        })
        .then(res => res.json())
        .then(data => {
            if (!dropdown || !dropdownResultsEl) return;

            const allResults = data.results || [];
            // Filter out the section currently being viewed
            const otherResults = allResults.filter(r => String(r.id) !== String(currentSectionId));

            dropdownResultsEl.innerHTML = '';

            if (otherResults.length > 0) {
                // Show up to 4 other matching sections
                const displayItems = otherResults.slice(0, 4);
                displayItems.forEach(item => {
                    const a = document.createElement('a');
                    a.href = (item.link || '#') + '?search_text=' + encodeURIComponent(query);
                    a.className = 'dropdown-item';

                    let snippetHtml = item.snippet || '';
                    a.innerHTML = `
                        <span class="dropdown-item-badge">${escapeHtml(item.type || 'Document')}</span>
                        <div class="dropdown-item-title">${escapeHtml(item.parent_title || '')}</div>
                        <div class="dropdown-item-subtitle">${escapeHtml(item.subtitle || '')}</div>
                        <div class="dropdown-item-snippet">${snippetHtml}</div>
                    `;
                    dropdownResultsEl.appendChild(a);
                });

                if (viewAllLink) {
                    viewAllLink.href = '/main_home_search?search_text=' + encodeURIComponent(query);
                    viewAllLink.innerHTML = 'View all ' + (data.total || otherResults.length).toLocaleString() + ' search results <i class="fa-solid fa-arrow-right"></i>';
                }
                if (dropdownFooterEl) dropdownFooterEl.style.display = 'block';
                dropdown.style.display = 'flex';
            } else if (sectionMatchCount === 0) {
                dropdownResultsEl.innerHTML = '<div style="padding: 16px 14px; color: #94a3b8; font-size: 13px; text-align: center;">No documents found matching "' + escapeHtml(query) + '"</div>';
                if (dropdownFooterEl) dropdownFooterEl.style.display = 'none';
                dropdown.style.display = 'flex';
            } else {
                // Matches exist in this section, but none in other documents
                dropdown.style.display = 'none';
            }
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                console.error('Content search error:', err);
            }
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Initialize on page load
    document.addEventListener("DOMContentLoaded", function() {
        if (!input) return;

        const urlParams = new URLSearchParams(window.location.search);
        const initialSearch = urlParams.get('search_text');

        if (initialSearch) {
            input.value = initialSearch;
            // Highlight in this section without showing dropdown popup immediately
            window.performInPageSearch(initialSearch, false);
        }

        // Handle typing in input
        input.addEventListener('input', function() {
            clearTimeout(searchDebounceTimer);
            const val = this.value.trim();
            searchDebounceTimer = setTimeout(function() {
                window.performInPageSearch(val, true);
            }, 150);
        });

        // Handle keyboard navigation (Enter, Shift+Enter, Escape)
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (marks.length > 0) {
                    if (e.shiftKey) {
                        activeMarkIndex = (activeMarkIndex - 1 + marks.length) % marks.length;
                    } else {
                        activeMarkIndex = (activeMarkIndex + 1) % marks.length;
                    }
                    updateActiveMark(activeMarkIndex);
                } else if (input.value.trim()) {
                    // No matches in this section -> navigate to global search
                    window.location.href = '/main_home_search?search_text=' + encodeURIComponent(input.value.trim());
                }
            } else if (e.key === 'Escape') {
                if (dropdown) dropdown.style.display = 'none';
            }
        });

        // Previous match button
        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (marks.length > 0) {
                    activeMarkIndex = (activeMarkIndex - 1 + marks.length) % marks.length;
                    updateActiveMark(activeMarkIndex);
                }
            });
        }

        // Next match button
        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (marks.length > 0) {
                    activeMarkIndex = (activeMarkIndex + 1) % marks.length;
                    updateActiveMark(activeMarkIndex);
                }
            });
        }

        // Clear button
        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = '';
                clearHighlights();
                if (tools) tools.style.display = 'none';
                if (dropdown) dropdown.style.display = 'none';
                if (window.history.replaceState) {
                    window.history.replaceState(null, '', window.location.pathname);
                }
                input.focus();
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (dropdown && !dropdown.contains(e.target) && !input.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });
})();
</script>
