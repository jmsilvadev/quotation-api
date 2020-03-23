<?php

namespace App\DTO;

use App\Exceptions\ValidationException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

class DataTransformerObjectConverter implements ParamConverterInterface
{

    private $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $this->serializer = new Serializer(array($normalizer));
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $data = $request->request->all();
        if ($request->headers->get('Content-Type') == 'application/json') {
            $data = json_decode($request->getContent());
        }
        
        $class = $configuration->getClass();

        if ($class == "Symfony\\Component\\Validator\\Validator\\ValidatorInterface") {
            return true;
        }

        $dto = $this->serializer->denormalize($data, $class);

        $request->attributes->set($configuration->getName(), $dto);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (!$configuration->getClass()) {
            return false;
        }

        return true;
    }
}
