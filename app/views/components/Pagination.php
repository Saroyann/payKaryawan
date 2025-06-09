
<?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?<?= isset($search_id) && $search_id !== '' ? 'search_id=' . urlencode($search_id) . '&' : '' ?>page=<?= $page - 1 ?>"
                    tabindex="-1">Sebelumnya</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?<?= isset($search_id) && $search_id !== '' ? 'search_id=' . urlencode($search_id) . '&' : '' ?>page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?<?= isset($search_id) && $search_id !== '' ? 'search_id=' . urlencode($search_id) . '&' : '' ?>page=<?= $page + 1 ?>">
                    Selanjutnya
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>