const currentAccountDefault = {
    accountHolder: {
        accountHolderId: null,
        name: '',
        birthDate: '',
        sex: '',
        pin: ''
    },
    accountId: null,
    view: '',
    interestRate: null,
    notifications: false,
    goalBalance: null,
    lowBalanceAlert: null,
    distributionDay: null,
    subscribedCategories: []
};

const state = {
    loading: false,
    accountList: [],
    currentAccount: currentAccountDefault
};


const getters = {
    accountSubedCats: state => state.currentAccount.subscribedCategories.filter(cat => cat.categoryId !== 1),
    accountInterestCat: state => state.currentAccount.subscribedCategories.find(cat => cat.categoryId === 1),
    bankSubedCats: state => state.accountList.map(account => account.subscribedCategories.filter(cat => cat.categoryId !== 1)),
    bankInterestCats: state => state.accountList.map(account => account.subscribedCategories.find(cat => cat.categoryId === 1))
};

// direct mutations
// store.commit('mutationName', payload)
const mutations = {
    setAccounts(state, accountList) {
        state.accountList = accountList;
    },
    setAccountsLoading (state, payload) {
        state.loading = payload;
    },
    addAccount(state, account) {
        state.accountList = state.accountList.concat(account);
    },
    updateAccount(state, updatedAccount) {
        state.accountList = state.accountList.map(account => {
            if (account.id == updatedAccount.id)
                return updatedAccount;
            else
                return account;
        })
    },
    updateAccountHolder(state, updatedAccountHolder) {
        state.accountList = state.accountList.map(account => {
            if (account.accountHolder.id == updatedAccountHolder.id)
                account.accountHolder = updatedAccountHolder;
            return account;
        })
    },
    setCurrentById(state, id) {
         let account = state.accountList.find( item => item.id == id);
         state.currentAccount = account ? account : currentAccountDefault;
    },
    setCurrentByObj(state, account) {
        state.currentAccount = account;
    },
    unSetCurrent(state) {
        state.currentAccount = currentAccountDefault;
    },
    changeAccountBalance(state, {accountId, type, amount}) {
        state.accountList = state.accountList.map(account => {
            if (account.id != accountId) return account;
            if (type == 'deposit') {
                account.balance += amount;
            } else if (type == 'withdrawal') {
                account.balance -= amount;
            }
            return account;
        });
    },
    changeAccountCategoryBalance(state, {accountId, type, split}) {
        let splitMap = {};
        split.forEach( item => {
            if (!(item.categoryId in splitMap)) {
                splitMap[item.categoryId] = 0;
            }
            splitMap[item.categoryId] += item.amount
        });

        state.accountList = state.accountList.map( account => {
            if (account.id == accountId) {
                account.subscribedCategories = account.subscribedCategories.map(cat => {
                    if (cat.categoryId in splitMap) {
                        cat.balance += splitMap[cat.categoryId];
                    }
                    return cat;
                })
            }
            return account;
        })
    },
    setSubscribedCats(state, payload) {
        state.accountList = state.accountList.map( account => {
            account.subscribedCategories = payload[account.id];
            return account;
        });
    },
    addTransaction(state, payload) {
        state.accountList = state.accountList.map( account => {
            if (account.id == payload.accountId) {
                account.transactions = [payload].concat(account.transactions);    
            }
            return account;
        });
    }
};

// async mutations
// store.dispatch('actionName', payload)
const actions = {
    fetchAllBankAccounts(context) {
        return new Promise((resolve, reject) => {
            context.commit('setAccountsLoading', true);
            axios.get('/api/account')
            .then((response) => {
                context.commit('setAccounts', response.data.data)
                context.commit('setAccountsLoading', false);
                resolve()
            })
            .catch((error) => {
                console.log(error);
                reject(error);
            });
        });
    },
    fetchBankAccount(context, accountId) {
        return new Promise((resolve, reject) => {
            context.commit('setAccountsLoading', true);
            axios.get(`/api/account/${accountId}`)
            .then((response) => {
                context.commit('setAccounts', [response.data.data]);
                context.commit('setCurrentByObj', response.data.data);
                context.commit('setAccountsLoading', false);
                resolve()
            })
            .catch((error) => {
                console.log(error);
                reject(error);
            });
        });
    },
    createAccount(context, payload) {
        return new Promise((resolve, reject) => {
            context.commit('setAccountsLoading', true);
            axios.post('/api/account', payload)
            .then((response) => {
                context.commit('addAccount', response.data.data);
                context.commit('setAccountsLoading', false);
                resolve();
            })
            .catch((error) => {
                reject(error);
            });
        });
    },
    updateAccount(context, {accountId, data}) {
        return new Promise((resolve, reject) => {
            // context.commit('setAccountsLoading', true);
            axios.patch(`/api/account/${accountId}`, {
                'interest_rate': Number(data.interestRate),
                'rate_interval': data.rateInterval,
                'frequency': data.frequency,
                'distribution_day': parseInt(data.distributionDay)
            }).then((response) => {
                context.commit('updateAccount', response.data.data);
                context.commit('setCurrentByObj', response.data.data);
                context.commit('setAccountsLoading', false);
                resolve();
            })
            .catch((error) => {
                reject(error);
            });
        });
    },
    updateAccountHolder(context, data) {
        return new Promise((resolve, reject) => {
            context.commit('setAccountsLoading', true);
            axios.put(`/api/account-holder/${data.id}`, data)
            .then((response) => {
                context.commit('updateAccountHolder', response.data.data);
                context.commit('setAccountsLoading', false);
                resolve();
            })
            .catch((error) => {
                reject(error);
            });
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};