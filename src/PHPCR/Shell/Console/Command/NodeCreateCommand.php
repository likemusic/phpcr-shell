<?php

namespace PHPCR\Shell\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use PHPCR\Util\CND\Writer\CndWriter;
use PHPCR\NodeType\NoSuchNodeTypeException;
use PHPCR\Util\CND\Parser\CndParser;
use PHPCR\NamespaceException;
use Symfony\Component\Console\Input\InputOption;

class NodeCreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('node:create');
        $this->setDescription('Create a node at the current path');
        $this->addArgument('relPath', null, InputArgument::REQUIRED, null, 'The name of the node to create');
        $this->addArgument('primaryNodeTypeName', null, InputArgument::OPTIONAL, null, 'Optional name of primary node type to use');
        $this->setHelp(<<<HERE
Creates a new node at the specified <info>relPath</info>

This is session-write method, meaning that the addition of the new node
is dispatched upon SessionInterface::save().

The <info>relPath</info> provided must not have an index on its final element,
otherwise a RepositoryException is thrown.

If ordering is supported by the node type of the parent node of the new
node then the new node is appended to the end of the child node list.

If <info>primaryNodeTypeName</info> is specified, this type will be used (or a
ConstraintViolationException thrown if this child type is not allowed).
Otherwise the new node's primary node type will be determined by the
child node definitions in the node types of its parent. This may occur
either immediately, on dispatch (save, whether within or without
transactions) or on persist (save without transactions, commit within
a transaction), depending on the implementation.
HERE
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $session = $this->getHelper('phpcr')->getSession();
        $relPath = $input->getArgument('relPath');
        $primaryNodeTypeName = $input->getArgument('primaryNodeTypeName');
        $currentNode = $session->getCurrentNode();
        $currentNode->addNode($relPath, $primaryNodeTypeName);
    }
}
