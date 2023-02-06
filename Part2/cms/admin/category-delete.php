<?php
declare(strict_types = 1);
include '../includes/database-connection.php';
include '../includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // get and validate id
$category = '';                                           // initialize category name

if (!$id){
    redirect('categories.php', ['failure' => 'Category not found']);
}

$sql = "SELECT name FROM category WHERE id = :id;";         //SQL to get category name
$category = pdo($pdo, $sql, [$id])->fetchColumn();          //Get Category Name
if (!$category){
    redirect('categories.php', ['failure' => 'Category not found']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {
        $sql = "DELETE FROM category WHERE id = :id;";      // sql delete category
        pdo($pdo, $sql, [$id]);                             // delete category
        redirect('categories.php', ['success' => 'Category deleted']);
    } catch (PDOException $e){
        if ($e->errorInfo[1] === 1451) { //1451 is preventing the category being deleted
            redirect('categories.php', ['failure' => 'Category contains articles that must be moved or deleted before you can delete it']);
        } else {
            throw $e;
        }
    }
}?>

<?php include '../includes/admin-header.php';?>
    <main class="container admin" id="content">
        <h2>Delete Category</h2>
        <form action="category-delete.php?id=<?= $id ?>" method="POST" class="narrow">
            <p>Click confirm to delete the category: <em><?= html_escape($category) ?></em></p>
            <input type="submit" name="delete" value="Confirm" class="btn btn-primary">
            <a href="categories.php" class="btn btn-danger">cancel</a>           
        </form>
    </main>
<?php include '../includes/admin-footer.php';?>