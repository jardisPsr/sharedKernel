<?php

declare(strict_types=1);

namespace JardisPsr\SharedKernel;

/**
 * Workflow configuration interface for defining workflow nodes.
 *
 * Provides a fluent interface for building workflow configurations with nodes
 * that support conditional branching based on success/failure outcomes.
 */
interface WorkFlowConfigInterface
{
    /**
     * Adds a node to the workflow configuration.
     *
     * Nodes define the sequence of handlers to execute, with optional branching
     * based on execution results.
     *
     * @param string $handlerClass The fully qualified class name of the handler
     * @param string|null $onSuccessClass Optional handler class to execute on success
     * @param string|null $onFailClass Optional handler class to execute on failure
     * @return self Returns instance for method chaining
     */
    public function addNode(string $handlerClass, ?string $onSuccessClass = null, ?string $onFailClass = null): self;

    /**
     * Gets all nodes in the workflow configuration.
     *
     * @return array<int, array{handler: string, onSuccess: string|null, onFail: string|null}> Array of node definitions
     */
    public function getNodes(): array;
}
