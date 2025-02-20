declare global {
    namespace NodeJS {
      interface ProcessEnv {
        ENDPOINT: string;
      }
    }
  }
  
export {};