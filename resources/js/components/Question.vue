<script>
import QuestionAffect from "./QuestionAffect";

export default {
  props: ["attributes"],

  components: {
    QuestionAffect,
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
