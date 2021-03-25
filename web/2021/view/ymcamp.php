<!DOCTYPE html>
<html lang="en-us">

<head>
    <?php $page = "YM Camp 2021" ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/head.php'; ?>
</head>

<body>
    <aside>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/alert.php'; ?>
    </aside>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/nav-expd.php'; ?>
    </header>
    <main>    
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/countdown.php'; ?>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/schedule-ym.php'; ?>
        <div class="pillars"></div>
        <div class="gallery"></div>
        <div class="FAQ"></div>
        <div class="contact"></div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/scripture.php'; ?>
    </main>
    <footer>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/2021/common/footer.php'; ?>
    </footer>
    <script src="js/countdown.js"></script>
</body>
</html>