<?php

declare(strict_types=1);

namespace JardisPsr\SharedKernel;

use Exception;

/**
 * Workflow interface for orchestrating complex domain operations.
 *
 * Executes a series of configured workflow nodes within a bounded context,
 * enabling complex multi-step processes with conditional branching.
 */
interface WorkflowInterface
{
    /**
     * Executes the workflow with the given configuration and parameters.
     *
     * Orchestrates the execution of workflow nodes defined in the configuration,
     * passing through the bounded context for use case execution.
     *
     * @param BoundedContextInterface $boundedContext The bounded context for executing use cases
     * @param WorkFlowConfigInterface $workFlowConfig The workflow configuration with nodes
     * @param mixed ...$parameters Additional parameters to pass through the workflow
     * @return array<string, mixed> Results from the workflow execution
     * @throws Exception If workflow execution fails
     */
    public function __invoke(
        BoundedContextInterface $boundedContext,
        WorkFlowConfigInterface $workFlowConfig,
        mixed ...$parameters
    ): array;
}
