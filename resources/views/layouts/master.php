<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="<?=asset('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?=asset('assets/css/bootstrap-icons.css') ?>">
</head>
<body>
    <header>
        <?php includeFile('shared/header'); ?>
    </header>
    <main>
        <div class="container">
            <?php yieldSection('content'); ?>
        </div>
    </main>
    <script src="<?=asset('assets/js/jquery.js') ?>"></script>
    <script src="<?=asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <?php yieldSection('scripts'); ?>
    <script>
        //common ajax method
        function ajaxCall(method, url, data, callback) {
            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'json',
                success: function(response) {
                    callback(response);
                },
                error: function(response) {
                    callback(response, 'error');
                }
            });
        }
    </script>
</body>
</html>
