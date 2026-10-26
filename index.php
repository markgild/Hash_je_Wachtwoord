<?php

$bestand = __DIR__ . "/users.json";

$inhoud = file_get_contents($bestand);
$gebruikers = json_decode($inhoud, true);

if (!is_array($gebruikers)) {
    echo "Fout: het gebruikersbestand is ongeldig.\n";
    exit;
}

echo "=== Hash je Wachtwoord ===\n";
echo "1. Regestreren\n";
echo "2. Inloggen\n";
echo "Kies een optie: ";

$optie = trim(fgets(STDIN));

if ($optie === "2") {
    echo "Voer je e-mailadres in: ";
    $email = strtolower(trim(fgets(STDIN)));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Fout: voer een geldig e-mailadres in.\n";
        exit;
    }

    if (!isset($gebruikers[$email])) {
        echo "Fout: dit e-mailadres is niet geregistreerd.\n";
        exit;
    }

    echo "Voer je wachtwoord in: ";
    $wachtwoord = trim(fgets(STDIN));

    if (password_verify($wachtwoord, $gebruikers[$email])) {
        echo "Inloggen gelukt!\n";
    } else {
        echo "Fout: wachtwoord incorrect.\n";
    }

    exit;
} elseif ($optie !== "1") {
    echo "Fout: ongeldig optie.\n";
    exit;
}

echo "Voer je e-mailadres in: ";
$email = strtolower(trim(fgets(STDIN)));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Fout: voer een geldig e-mailadres in.\n";
    exit;
}

if (isset($gebruikers[$email])) {
    echo "Fout: dit e-mailadres is al geregistreerd.\n";
    exit;
}

echo "Voer een wachtwoord in: ";
$wachtwoord = trim(fgets(STDIN));

echo "Bevestig je wachtwoord: ";
$wachtwoord_bevestiging = trim(fgets(STDIN));

if (empty($wachtwoord) || empty($wachtwoord_bevestiging)) {
    echo "Fout: beide wachtwoordvelden zijn verplicht.\n";
} elseif ($wachtwoord !== $wachtwoord_bevestiging) {
    echo "Fout: de ingevoerde wachtwoorden komen niet overeen.\n";
} else {
    try {
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

        if ($hash === false) {
            echo "Fout: het wachtwoord kon niet worden gehasht.\n";
            exit;
        }
    } catch (Throwable $e) {
        echo "Fout: " . $e->getMessage() . "\n";
        exit;
    }

    // echo "Je wachtwoord is veilig gehasht.\n";
    // echo "Hash: " . $hash . "\n";

    echo "Voer het wachtwoord opnieuw in: ";
    $wachtwoord_verificatie = trim(fgets(STDIN));

    if (password_verify($wachtwoord_verificatie, $hash)) {
        $gebruikers[$email] = $hash;

        if (file_put_contents($bestand, json_encode($gebruikers, JSON_PRETTY_PRINT)) === false) {
            echo "Fout: het gebruikersbestand kon niet worden bijgewerkt.\n";
            exit;
        }

        echo "Wachtwoord correct!\n";
        echo "Gebruiker succesvol geregistreerd.\n";
    } else {
        echo "Wachtwoord incorrect!\n";
    }
}
?>