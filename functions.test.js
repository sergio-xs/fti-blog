const { boolean } = require('yargs');

 kontrolloFjalekalimin = require('./functions');

test('Kontrolli i domainit te emailit ', () =>{
    expect(kontrolloFjalekalimin("serxhinjoh@gmail.com")).toBe(true);
});


