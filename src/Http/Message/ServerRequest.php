<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by Nyholm/psr7 and Laminas
 *
 * @link    https://github.com/Nyholm/psr7
 * @license https://github.com/Nyholm/psr7/blob/master/LICENSE
 * @link    https://github.com/laminas/laminas-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

namespace Phalcon\Http\Message;

use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Phalcon\Http\Message\Interfaces\ServerRequestInterface;
use Phalcon\Http\Message\Interfaces\StreamInterface;
use Phalcon\Http\Message\Interfaces\UploadedFileInterface;
use Phalcon\Http\Message\Interfaces\UriInterface;
use Phalcon\Http\Message\Stream\Input;
use Phalcon\Support\Collection;
use Phalcon\Support\Collection\CollectionInterface;

use function is_array;
use function is_object;

/**
 * ServerRequest
 */
final class ServerRequest extends AbstractRequest implements
    ServerRequestInterface
{
    /**
     * @var CollectionInterface
     */
    protected CollectionInterface $attributes;

    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The data MUST be compatible with the structure of the $_COOKIE
     * superglobal.
     *
     * @var array
     */
    protected array $cookieParams = [];

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @var mixed
     */
    protected $parsedBody = null;

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from
     * `getUri()->getQuery()` or from the `QUERY_STRING` server param.
     *
     * @var array
     */
    protected array $queryParams = [];

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @var array
     */
    protected array $serverParams = [];

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Phalcon\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @var array
     */
    protected array $uploadedFiles = [];

    /**
     * ServerRequest constructor.
     *
     * @param string                    $method
     * @param UriInterface|string|null  $uri
     * @param array                     $serverParams
     * @param StreamInterface|string    $body
     * @param array|CollectionInterface $headers
     * @param array                     $cookies
     * @param array                     $queryParams
     * @param array                     $uploadFiles
     * @param null|array|object         $parsedBody
     * @param string                    $protocol
     */
    public function __construct(
        string $method = self::METHOD_GET,
        $uri = null,
        array $serverParams = [],
        $body = "php://input",
        $headers = [],
        array $cookies = [],
        array $queryParams = [],
        array $uploadFiles = [],
        $parsedBody = null,
        string $protocol = "1.1"
    ) {
        if ("php://input" === $body) {
            $body = new Input();
        }

        $this->checkUploadedFiles($uploadFiles);

        $collection            = new Headers();
        $this->protocolVersion = $this->processProtocol($protocol);
        $this->method          = $this->processMethod($method);
        $this->uri             = $this->processUri($uri);
        $this->headers         = $collection->processHeaders(
            $headers,
            $this->uri
        );
        $this->body            = $this->processBody($body, "w+b");
        $this->uploadedFiles   = $uploadFiles;
        $this->parsedBody      = $parsedBody;
        $this->serverParams    = $serverParams;
        $this->cookieParams    = $cookies;
        $this->queryParams     = $queryParams;
        $this->attributes      = new Collection();
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * Retrieves a single derived request attribute as described in
     * getAttributes(). If the attribute has not been previously set, returns
     * the default value as provided.
     *
     * This method obviates the need for a hasAttribute() method, as it allows
     * specifying a default value to return if the attribute is not found.
     *
     * @param string     $name
     * @param mixed|null $defaultValue
     *
     * @return mixed
     */
    public function getAttribute(string $name, $defaultValue = null)
    {
        return $this->attributes->get($name, $defaultValue);
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * The request 'attributes' may be used to allow injection of any
     * parameters derived from the request: e.g., the results of path
     * match operations; the results of decrypting cookies; the results of
     * deserializing non-form-encoded message bodies; etc. Attributes
     * will be application and request specific, and CAN be mutable.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes->toArray();
    }

    /**
     * @return array
     */
    public function getCookieParams(): array
    {
        return $this->cookieParams;
    }

    /**
     * @return array|object|null
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array
     */
    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    /**
     * @return array
     */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated attribute.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ServerRequest
     */
    public function withAttribute(string $name, $value): ServerRequest
    {
        $attributes = clone $this->attributes;

        $attributes->set($name, $value);

        return $this->cloneInstance($attributes, "attributes");
    }

    /**
     * Return an instance with the specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated cookie values.
     *
     * @param array $cookies
     *
     * @return ServerRequest
     */
    public function withCookieParams(array $cookies): ServerRequest
    {
        return $this->cloneInstance($cookies, "cookieParams");
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or
     * objects, or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array|object|null $data
     *
     * @return ServerRequest
     * @throws InvalidArgumentException if an unsupported argument type is
     *                                  provided.
     *
     */
    public function withParsedBody($data): ServerRequest
    {
        if (
            !is_array($data) &&
            !is_object($data) &&
            null !== $data
        ) {
            throw new InvalidArgumentException(
                "The method expects null, an array or an object"
            );
        }

        return $this->cloneInstance($data, "parsedBody");
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated query string arguments.
     *
     * @param array $query
     *
     * @return ServerRequest
     */
    public function withQueryParams(array $query): ServerRequest
    {
        return $this->cloneInstance($query, "queryParams");
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array $uploadedFiles
     *
     * @return ServerRequest
     * @throws InvalidArgumentException if an invalid structure is provided.
     *
     */
    public function withUploadedFiles(array $uploadedFiles): ServerRequest
    {
        $this->checkUploadedFiles($uploadedFiles);

        return $this->cloneInstance($uploadedFiles, "uploadedFiles");
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the attribute.
     *
     * @param string $name
     *
     * @return ServerRequest
     */
    public function withoutAttribute(string $name): ServerRequest
    {
        $attributes = clone $this->attributes;
        $attributes->remove($name);

        return $this->cloneInstance($attributes, "attributes");
    }

    /**
     * Checks the uploaded files
     *
     * @param array $files
     */
    private function checkUploadedFiles(array $files): void
    {
        foreach ($files as $file) {
            if (is_array($file)) {
                $this->checkUploadedFiles($file);
            } else {
                if (!($file instanceof UploadedFileInterface)) {
                    throw new InvalidArgumentException(
                        "Invalid uploaded file"
                    );
                }
            }
        }
    }
}
