<?php if ($total > 3): ?>
    <nav aria-label="Page navigation example" class="mt-3">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= ceil($total / 3); $i++): ?>
                <li class="page-item <?php echo $requestedPage === $i ? 'active' : ''; ?>">
                    <a class="page-link" href="/?p=<?php echo $i; ?><?php echo '&sort=' . $requestedSort; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>