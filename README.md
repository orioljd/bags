# Test

This is a test of https://katalyst.codurance.com/bags

# Instalation

This works with docker if you have docker installed you can install it by :

`make build`

It installs all vendor and docker installation necessary.

Tot do tests use:

`make tests`

# Classes

More or less the classes and methods used are:

 ## Durance
  ### properties
    MAX_BAGS = 4
    bags
    bagpacks

  ### Methods
    stashItem
    organize

 ## Storable
  ### Properties
    capacity
    items

  ### Methods
    addItem
    isFull

 ## Backpack
  ### Properties
    MAX_ITEMS = 8

 ## Bag
  ### Properties
    MAX_ITEMS = 4
    category

  ### Methods
    sortItems

 ## Item
  ## Properties
    category