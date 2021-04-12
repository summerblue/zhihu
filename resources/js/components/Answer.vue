<script>
import AnswerAffect from "./AnswerAffect";
export default {
  props: ["attributes"],

  components: {
    AnswerAffect,
  },

  data() {
    return {
      content: this.attributes.content,
    };
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    },
  },
};
</script>
