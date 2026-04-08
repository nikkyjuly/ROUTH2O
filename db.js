// ==========================================
// db.js - Mini Framework IndexedDB (Global)
// ==========================================

const DB_NAME = 'ROUTH2O_DB';
const DB_VERSION = 1;
const STORE_NAME = 'usuarios_dados';

// Função 1: Iniciar o banco de dados
// Explicação: Abre a conexão com o IndexedDB. Se o banco não existir ou a versão mudar, ele cria a tabela (Object Store).
const initDB = () => {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                // Cria a tabela com um ID auto-incremental
                db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
            }
        };

        request.onsuccess = (event) => {
            resolve(event.target.result);
        };

        request.onerror = (event) => {
            reject(`Erro ao abrir IndexedDB: ${event.target.error}`);
        };
    });
};

// Função 2: Adicionar um item
// Explicação: Abre uma transação de leitura/escrita e adiciona o objeto recebido no banco.
const adicionarItem = async (dado) => {
    const db = await initDB();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);
        const request = store.add(dado);

        request.onsuccess = () => resolve('Dado salvo com sucesso!');
        request.onerror = (event) => reject(`Erro ao salvar: ${event.target.error}`);
    });
};

// Função 3: Buscar itens
// Explicação: Abre uma transação de leitura, busca todos os registros da tabela e retorna um array com os dados.
const buscarItens = async () => {
    const db = await initDB();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([STORE_NAME], 'readonly');
        const store = transaction.objectStore(STORE_NAME);
        const request = store.getAll();

        request.onsuccess = () => resolve(request.result);
        request.onerror = (event) => reject(`Erro ao buscar: ${event.target.error}`);
    });
};

// Função 4: Deletar item
// Explicação: Remove um registro específico baseado no seu ID.
const deletarItem = async (id) => {
    const db = await initDB();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([STORE_NAME], 'readwrite');
        const store = transaction.objectStore(STORE_NAME);
        const request = store.delete(id);

        request.onsuccess = () => resolve('Item deletado com sucesso!');
        request.onerror = (event) => reject(`Erro ao deletar: ${event.target.error}`);
    });
};
