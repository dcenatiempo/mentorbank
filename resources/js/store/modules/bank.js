import {toSpinalCase} from '../../helpers.js';

const state = {
    loading: true,
    id: null,
    name: '',
    totalAccruedInterest: 0,
    createdAt: '',
    updatedAt: '',
    planType: 'free', // paid
    planExpires: null, // date
    autoRenew: null, // bool,
    // deletedAt: '',
    // inviteCode: ,,
};


const getters = {
    openSince: state => moment.utc(state.createdAt.date).fromNow(),
    isInGracePeriod: state => {
        if (!state.planExpires) {
            return false
        }
        if ('free' == state.planType)
        return false;

        let expires = moment.utc(state.planExpires.date);
        let now = moment.utc();
        if (expires > now)
            return false;

        let dif = now.diff(expires, 'days');
        if (dif > 30)
            return false;
        return true
    },
    isExpired: state => {
        if (!state.planExpires) {
            return false
        }
        if ('free' == state.planType)
        return false;

        let expires = moment.utc(state.planExpires.date);
        let now = moment.utc();
        if (expires > now)
            return false;
        
        return true;
    },
};

const mutations = {
    setBank (state, payload) {
        state = Object.assign( state, payload, {loading: false} );
    },
    setBankLoading (state, payload) {
        state.loading = payload;
    },
};

const actions = {
    fetchBank (context) {
        context.commit('setBankLoading', true);
        axios.get('/api/bank')
        .then(function (response) {
            context.commit('setBank', response.data.data);
            context.commit('setBankLoading', false);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    createBank (context, name) {
        context.commit('setBankLoading', true);
    
        axios.post('/api/bank', {name})
            .then( response => {
                context.commit('setBank', response.data.data)
                context.commit('setBankLoading', false);
                return Promise.resolve();
            })
            .catch( err => {
                return Promise.reject(err);
            });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};