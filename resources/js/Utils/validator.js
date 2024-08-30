import {
    required,
    email,
    helpers,
    minLength,
    maxLength,
    sameAs,
} from "@vuelidate/validators";

export default {
    required: helpers.withMessage("Este campo é obrigatório", required),
    email: helpers.withMessage("Este campo deve ser um email válido!", email),
    minLength: (min) =>
        helpers.withMessage(
            `Este campo deve ter no mínimo ${min} caracteres`,
            minLength(min)
        ),
    maxLength: (max) =>
        helpers.withMessage(
            `Este campo deve ter no máximo ${max} caracteres`,
            maxLength(max)
        ),
    sameAs: (passwordRef) =>
        helpers.withMessage("As senhas devem coincidir", sameAs(passwordRef)),
    minDigits: (min) =>
        helpers.withMessage(
            `Este campo deve ter no mínimo ${min} dígitos`,
            minLength(min)
        ),
};
