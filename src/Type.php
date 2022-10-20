<?php

namespace Majkel\Yafl;

/**
 * Since php doesnt have based enums (haskell like) we have to do it like this
 */
class Type
{
    public function __construct(
        public BaseType $type,
        public ?string $name = null,
        /** @var array<self> $body */
        public ?array $body = null
    ) {

    }

    public function setGeneric(self $new): static    
    {
        foreach ($new as $propery => $value) {
            $this->{$propery} = $value;
        }
        return $this;
    }

    public static function fromString(?string $type): ?self
    {
        return match ($type) {
            'string' => new self(BaseType::String),
            'int' => new self(BaseType::Int),
            null => null,
            default => new self(BaseType::GenericType, $type),
        };
    }

    public static function getLambdaReturn(self $type): self
    {
        if ($type->type == BaseType::Lambda) {
            return self::getLambdaReturn($type->body[1]);
        }
        return $type;
    }

}
