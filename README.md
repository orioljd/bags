# Test

This is a test based on this [kata](https://katalyst.codurance.com/bags)

I know that null bags are not used, the kata don't say what to do with them,
so for time reasons I didn't implement it.

# Instalation

This works with docker if you have docker installed you can install this container by :

`make build`

It installs all vendor and docker installation necessary.

# Tests

To do tests use:

`make tests`

# Classes

The classes used are:

## Durance
> This is the Main Class it stash, store and organize items. So it has the backpack, bags and methods to organize and stash items.

## Storable
> This is an abstract parent class of **Backpack**, **OrganizerBag** and **Bag**. This has the common methods we need to manage the items.

## OrganizerBag
> It doesn't have any category and it can storage unlimited items.

## Backpack
> It doesn't have any category and has a 8 maximum number of items.

## Bag
> It can have a category or not and has a 4 maximum number of items.

## Item
> It always has a category, so we need it to put them in the correct bag, when
method organized is invoked.

## StorableException
> It is a class to have all the exceptions.
