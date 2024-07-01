<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-shape {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 80%, 0% 100%);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-md w-full">
        <div class="relative custom-shape bg-purple-600 p-8">
            <form method="post" action="/" class="space-y-6">
                <div>
                    <label for="login" class="sr-only">Nom d'utilisateur</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="login" name="login" type="text" placeholder="Nom d'utilisateur" class="w-full py-3 pl-10 pr-4 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                    </div>
                </div>
                <div>
                    <label for="motdepasse" class="sr-only">Mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="motdepasse" name="motdepasse" type="password" placeholder="Mot de passe" class="w-full py-3 pl-10 pr-4 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full py-3 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">Se connecter</button>
                </div>
            </form>
        </div>
        <div class="p-4 text-center">
            <p class="text-gray-600">log in via</p>
            <div class="flex justify-center space-x-4 mt-2">
                <a href="#" class="text-gray-600 hover:text-purple-600"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-600 hover:text-purple-600"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-600 hover:text-purple-600"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
