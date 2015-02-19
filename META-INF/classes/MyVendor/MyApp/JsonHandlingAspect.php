<?php

namespace MyVendor\MyApp;

use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;

/**
 * @Aspect
 */
class JsonHandlingAspect
{
    /**
     * @Pointcut("call(\MyVendor\MyApp\*Servlet->do*())")
     */
    public function allServletDoMethods() {}

    /**
     * @Around("pointcut(allServletDoMethods())")
     */
    public function jsonHandlingAdvice(MethodInvocationInterface $methodInvocation)
    {
        // get servlet method params to local refs
        $parameters = $methodInvocation->getParameters();
        $servletRequest = $parameters['servletRequest'];
        $servletResponse = $parameters['servletResponse'];

        // try to handle request processing
        try {
            // only if request has valid json
            if (!is_object(json_decode($servletRequest->getBodyContent()))) {
                throw new \Exception('Invalid request format', 400);
            }
            // set json parsed object into data property of servlet object
            $methodInvocation->getContext()->data = json_decode(
                $servletRequest->getBodyContent()
            );
            // call orig function
            $responseJsonObject = $methodInvocation->proceed();
        } catch(\Exception $e) {
            $servletResponse->setStatusCode(
                $e->getCode() ? $e->getCode() : 400
            );
            // create error json response object
            $responseJsonObject = new \stdClass();
            $responseJsonObject->error = new \stdClass();
            $responseJsonObject->error->message = nl2br($e->getMessage());
        }
        // add json encoded string to response body stream
        $servletResponse->appendBodyStream(json_encode($responseJsonObject));
    }
}
