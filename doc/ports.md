# Ports

All available ports use the PHP namespace `Apparat\Kernel\Ports`.

## Facades

### `Kernel`

Main entry point for kernel operations like

* module registration (`register`),
* instance creation via the DI container (`create`),
* logging methods (`info`, `error`, `debug`, etc.)

## Abstract classes

### `AbstractLogger`

Abstract base class for custom loggers (extending the Monolog Logger).

### `AbstractModule`

Abstract base class for package manifest modules.

## Interfaces

### `Contract\DependencyInjectionContainerInterface`

Interface for custom DI containers. *apparat/kernel* ships with [level-2/dice](https://github.com/level-2/dice) as default DI container.

### `Contract\ModuleInterface`

Interface for package manifest modules.
