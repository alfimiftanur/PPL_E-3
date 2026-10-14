const express = require('express');
const OpenApiValidator = require('express-openapi-validator');

const seed = require('./data/seed.json');
const KICKOFFS = seed.kickoffs;
const MOMS = seed.moms;
const KNOWN_PROJECTS = seed.knownProjects;
const MOCK_TOKEN = process.env.MOCK_TOKEN || 'mock-token';

const app = express();
app.use(OpenApiValidator.middleware({
  apiSpec: './openapi.yaml',
  validateRequests: true,
  validateResponses: true,
  validateSecurity: {
    handlers: { bearerAuth: (req) => {
      const t = (req.headers.authorization || '').replace(/^Bearer /, '');
      if (t !== MOCK_TOKEN) { const e = new Error('unauth'); e.status = 401; throw e; }
      return true;
    } },
  },
}));

app.get('/api/v1/e3/projects/:projectId/execution-readiness', (req, res) => {
  const { projectId } = req.params;
  if (!KNOWN_PROJECTS.includes(projectId))
    return res.status(404).json({ code: 'PROJECT_NOT_FOUND', message: 'Proyek tidak ditemukan.' });
  const kickoff = [...KICKOFFS].reverse().find(k => k.projectId === projectId);
  const mom = kickoff && [...MOMS].reverse().find(m => m.kickoffId === kickoff.id);
  const done = mom?.status === 'selesai';
  res.json({
    projectId,
    kickoffId: kickoff ? String(kickoff.id) : null,
    momId: mom ? String(mom.id) : null,
    status: mom ? mom.status : null,
    completedAt: done ? mom.completedAt : null,
    readyForExecution: done,
  });
});

app.use((err, req, res, next) => {
  const s = err.status || 500;
  const code = { 401: 'UNAUTHENTICATED', 403: 'FORBIDDEN', 404: 'PROJECT_NOT_FOUND', 400: 'INVALID_REQUEST', 422: 'INVALID_REQUEST' }[s] || 'DEPENDENCY_UNAVAILABLE';
  res.status(s === 400 ? 422 : s).json({ code, message: s === 401 ? 'Token tidak ada atau tidak valid.' : err.message });
});
if (require.main === module) app.listen(process.env.PORT || 3000, () => console.log('E-3 API di http://localhost:' + (process.env.PORT || 3000)));
module.exports = app;
