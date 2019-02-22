<?php
/**
 * @var \App\ParserContext\Domain\ValueObjects\Domain $domain
 * @var \App\ParserContext\Domain\DTO\UrlInfoDTO $urlInfoDTO
 */
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Report</title>
</head>
<body>
    <div class="container">
        <div class="report mt-5">
            <h1>Report for domain <?= $domain->getDomain() ?></h1>
            <div class="table-container mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Link</th>
                            <th>Images count</th>
                            <th>Loading time</th>
                            <th>Depth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($urls): ?>
                            <?php foreach ($urls as $urlInfoDTO): ?>
                                <tr>
                                    <td><a href="<?= $urlInfoDTO->getUrl() ?>"><?= $urlInfoDTO->getUrl() ?></a></td>
                                    <td><?= $urlInfoDTO->getImagesCounter() ?></td>
                                    <td><?= $urlInfoDTO->getLoadingTime() ?></td>
                                    <td><?= $urlInfoDTO->getDepth() ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                    <td colspan="4">
                                        No links found
                                    </td>
                                </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>