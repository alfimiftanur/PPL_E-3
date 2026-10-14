const test = require('node:test');
const assert = require('node:assert');
const fs = require('node:fs');
const app = require('./server');

const ex = (f) => JSON.parse(fs.readFileSync(`./examples/${f}`, 'utf8'));
const H = { Authorization: 'Bearer mock-token' };
let server, base;
test.before(() => new Promise((r) => { server = app.listen(0, () => { base = `http://localhost:${server.address().port}/api/v1/e3/projects`; r(); }); }));
test.after(() => server.close());

const get = async (id, headers = H) => { const r = await fetch(`${base}/${id}/execution-readiness`, { headers }); return [r.status, await r.json()]; };

test('200 siap: sama dengan examples/success.json', async () => {
  const [s, b] = await get('PRJ-DEMO-001'); assert.strictEqual(s, 200); assert.deepStrictEqual(b, ex('success.json'));
});
test('200 tanpa kickoff/MoM: sama dengan examples/success-no-mom.json', async () => {
  const [s, b] = await get('PRJ-DEMO-002'); assert.strictEqual(s, 200); assert.deepStrictEqual(b, ex('success-no-mom.json'));
});
test('404 proyek tidak dikenal: sama dengan examples/error.json', async () => {
  const [s, b] = await get('TIDAK-ADA'); assert.strictEqual(s, 404); assert.deepStrictEqual(b, ex('error.json'));
});
test('401 tanpa token', async () => {
  const [s, b] = await get('PRJ-DEMO-001', {}); assert.strictEqual(s, 401); assert.strictEqual(b.code, 'UNAUTHENTICATED');
});
