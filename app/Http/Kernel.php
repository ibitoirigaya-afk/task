protected $routeMiddleware = [
    // ...
    'checkAge' => \App\Http\Middleware\CheckAge::class,
  ];