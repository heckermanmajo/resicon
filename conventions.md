

### ASSERT
Assert that everything is always correct.
Even if it feels dumb.
Every function is a castle.

### Tests
Run all tests every time you make a change.
Never drop tests. Just don't break the code.

Make enough tests and don't stuff multiple tests into one file.

### Documentation
Document everything.

### PHP to C++

- We dont use mixed arrays
- We dont use Call by name 
- We dont use Reflection (in the simulation-part)
- We dont use dynamic function calls (in the simulation-part)
- We dont use dynamic values
- We dont use anonymous classes
- We dont use untyped parameters 
- Each variable has its own type defined by a /** @type TYPE */ comment

All Memory that an instance has, is bound to that instance and deleted
once the instance itself is deleted.

You dont have pointers to an instance, but references.
You cannot set a value to Reference twice.

If you delete a parent, all children are deleted.
You cannot trust a not children to exist. -> Children-Attribute.
#[Owner] #[Borrowed] 

Maybe we can use a List, and a Dict class with runtime type-checking.