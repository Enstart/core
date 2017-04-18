<?php namespace Enstart\Http;

interface ResponseInterface
{
    /**
     * Create a new response
     *
     * @param mixed $content The response content, see setContent()
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     *
     * @return Response
     */
    public function make($content = '', $status = 200, array $headers = []);

    /**
     * Create a new Stream Response
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     */
    public function stream(callable $callback = null, $status = 200, array $headers = []);


    /**
     * Create a new BinaryFileResponse
     *
     * @param \SplFileInfo|string $file               The file to stream
     * @param int                 $status             The response status code
     * @param array               $headers            An array of response headers
     * @param bool                $public             Files are public by default
     * @param null|string         $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool                $autoEtag           Whether the ETag header should be automatically set
     * @param bool                $autoLastModified   Whether the Last-Modified header should be automatically set
     */
    public function binaryFile($file, $status = 200, array $headers = [], $public = true, $contentDisposition = null, $autoEtag = false, $autoLastModified = true);

    /**
     * Create a new file download response
     *
     * @param string    $file  The file
     */
    public function fileDownload($file);

    /**
     * Create a json response
     *
     * @param mixed $data    The response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     */
    public function json($data = null, $status = 200, array $headers = []);

    /**
     * Create a redirect response
     *
     * @param string $url     The URL to redirect to
     * @param int    $status  The status code (302 by default)
     * @param array  $headers The headers (Location is always set to the given URL)
     *
     * @throws \InvalidArgumentException
     *
     * @see http://tools.ietf.org/html/rfc2616#section-10.3
     */
    public function redirect($url, $status = 302, array $headers = []);
}
