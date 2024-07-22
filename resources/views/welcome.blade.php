<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9fafb;
                color: #333;
                justify-content: center;
                align-items: center;
            }

            .card {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 1.5rem;
                margin: 1.5rem;
                max-width: 800px; 
                width: 100%;
            }
            .card-header {
                margin-bottom: 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 1rem;
            }

            ul {
                list-style-type: none; 
                padding: 0; 
                margin: 0;
            }

            li{
                padding: 10px;
            }

            /* Responsive Design */
            @media (max-width: 640px) {
                .card {
                    margin: 0.5rem;
                }
            }

        </style>

        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="card">
                <div class="card-header">
                    Task
                </div>
                @if (Route::has('login'))
                    <div class="card-body">
                        <ul>
                            @auth
                                <li>
                                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                                </li> 
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>
                                </li> 
                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                                    </li>  
                                @endif
                            @endif
                        </ul>
                       
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
