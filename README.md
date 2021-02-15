FOSPsrHttpBundle
================

FOSPsrHttpBundle provides support for HTTP messages interfaces defined in
[PSR-7][1] by integrating Symfony's [HttpMessageBridge][2] and [nyholm/psr7][3].

It allows to inject instances of `Psr\Http\Message\ServerRequestInterface`
and to return instances of `Psr\Http\Message\ResponseInterface` in controllers.

The bundle is a partial fork of [SensioFrameworkExtraBundle][3] which
discontinued PSR-7 support with version 6.0.

[1]: https://www.php-fig.org/psr/psr-7/
[2]: https://github.com/symfony/psr-http-message-bridge
[3]: https://github.com/Nyholm/psr7
[4]: https://github.com/sensiolabs/SensioFrameworkExtraBundle
