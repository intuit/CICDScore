var assert = require('assert');
var app = require('../js/calculate.js')
it('Testing core badges', function() {
assert.equal('Fly',app._test2.get_badge(91));
});

it('Testing DB connections', function() {
assert.equal('Advanced',app._test2.get_badge(88));
});

it('Testing calculate js', function() {
assert.equal('Skilled',app._test2.get_badge(68));
});

it('testing get_badge', function() {
assert.equal('Ready_to_Fly',app._test2.get_badge(29));
});

it('front_page', function() {
assert.equal('Newbie',app._test2.get_badge(13));
});
