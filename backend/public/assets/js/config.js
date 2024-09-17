const config = {
  baseApiUrl: "http://localhost/blogit/backend/routes",
  baseDomainUrl: "http://localhost/blogit",
};

export function getBaseApiUrl() {
  return config.baseApiUrl;
}

export function getBaseDomainUrl() {
  return config.baseDomainUrl;
}
