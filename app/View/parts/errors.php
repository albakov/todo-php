<?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($fields as $key => $field): ?>
            <?php if ($key === $_GET['error']): ?>
                Проверьте поле <?php echo $field['label']; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>