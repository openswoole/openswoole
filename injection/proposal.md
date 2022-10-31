# Abstract

Dependency injection is a technique that has been widely used since the advent of MVC architecture.
It follows the Dependency inversion in the Architectural principles, the principles witch ot the consensus of most programmers.

## Why not use PHP-DI

Genuinely PHP-DI is a good di package, whereas there're two things worth consider.

First, We expect to use a harmonized type of injection format in openswoole.
PHP-DI has many different types of dependency injection: autowiring/annotations/definitions. We hope this could be simple as well as one best practice is stunning.
Furthermore, PHP-DI integrates with some frameworks. We'd liked to give our customers a better coding experience when they use openswoole with other frameworks.
Say, while they are using Slim. In contrast to ask them requiring 'php-di/slim-bridge', using openswoole/injection might easier for them to understand.

Second, runtime efficiency may could be ameliorated by us. Most dependency injection packages are using reflection, which is pretty inefficient.
Perhaps use lambda expression(e.g. [Microsoft Linq expression](https://learn.microsoft.com/en-gb/dotnet/csharp/expression-trees)) as an implementation is worth trying for this repository.

# Structure

## Containers

## Data Structure

## Resource Scanner

## Implementation

# Terms & Conditions

...