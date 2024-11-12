<?php


include_once __DIR__ . '/../database/db.php';

function showCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    include __DIR__ . '/../views/cart.php'; // Afficher la vue du panier
}

function addToCart() {
    global $conn, $baseUri;

    $product_id = (int)$_GET['id']; // Récupérer l'ID du produit

    // Initialiser le panier s'il n'existe pas
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ajouter le produit au panier
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        try {
            // Récupérer les informations du produit depuis la base de données
            $query = "SELECT * FROM products WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                // Ajouter le produit au panier
                $_SESSION['cart'][$product_id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
                ];
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du produit : " . $e->getMessage();
        }
    }

    // Rediriger vers la page du panier
    header("Location: " . $baseUri . "/cart");
    exit();
}

function checkout() {
    global $conn, $baseUri;
    // Validation de la commande
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_name = trim($_POST['client_name']);
        $client_email = trim($_POST['client_email']);
        $errors = [];
        if (empty($client_name)) {
            $errors[] = "Le nom est requis.";
        }
        if (empty($client_email) || !filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Une adresse e-mail valide est requise.";
        }
        if (empty($errors)) {
            try {
                $total_price = 0;
                foreach ($_SESSION['cart'] as $product) {
                    $total_price += $product['price'] * $product['quantity'];
                }
                // Insertion de la commande dans la base de données
                $query = "INSERT INTO orders (product_id, client_name, client_email, quantity, total_price)
                          VALUES (:product_id, :client_name, :client_email, :quantity, :total_price)";
                $stmt = $conn->prepare($query);
                foreach ($_SESSION['cart'] as $product) {
                    $stmt->execute([
                        ':product_id' => $product['id'],
                        ':client_name' => $client_name,
                        ':client_email' => $client_email,
                        ':quantity' => $product['quantity'],
                        ':total_price' => $product['price'] * $product['quantity']
                    ]);
                }
                // Vider le panier après validation
                unset($_SESSION['cart']);
                header("Location: " . $baseUri . "/checkout?success=1");
                exit();
            } catch (PDOException $e) {
                $errors[] = "Erreur lors de l'enregistrement de la commande : " . $e->getMessage();
            }
        }
    }
    // Afficher la vue de validation de commande
    include __DIR__ . '/../views/checkout.php';
}
?>
?>
