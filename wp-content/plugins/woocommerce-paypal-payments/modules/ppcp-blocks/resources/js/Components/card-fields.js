import { useEffect, useState } from '@wordpress/element';

import {
	PayPalScriptProvider,
	PayPalCardFieldsProvider,
	PayPalCardFieldsForm,
} from '@paypal/react-paypal-js';

import { CheckoutHandler } from './checkout-handler';
import {
	createOrder,
	onApprove,
	createVaultSetupToken,
	onApproveSavePayment,
} from '../card-fields-config';
import { cartHasSubscriptionProducts } from '../Helper/Subscription';

export function CardFields( {
	config,
	eventRegistration,
	emitResponse,
} ) {
	const { onPaymentSetup } = eventRegistration;
	const { responseTypes } = emitResponse;

	const [ cardFieldsForm, setCardFieldsForm ] = useState();
	const getCardFieldsForm = ( cardFieldsForm ) => {
		setCardFieldsForm( cardFieldsForm );
	};

	const getSavePayment = ( savePayment ) => {
		localStorage.setItem( 'ppcp-save-card-payment', savePayment );
	};

	const hasSubscriptionProducts = cartHasSubscriptionProducts(
		config.scriptData
	);
	useEffect( () => {
		localStorage.removeItem( 'ppcp-save-card-payment' );

		if ( hasSubscriptionProducts ) {
			localStorage.setItem( 'ppcp-save-card-payment', 'true' );
		}
	}, [ hasSubscriptionProducts ] );

	useEffect(
		() =>
			onPaymentSetup( () => {
				async function handlePaymentProcessing() {
					await cardFieldsForm.submit().catch( ( error ) => {
						return {
							type: responseTypes.ERROR,
						};
					} );

					return {
						type: responseTypes.SUCCESS,
					};
				}

				return handlePaymentProcessing();
			} ),
		[ onPaymentSetup, cardFieldsForm ]
	);

	return (
		<>
			<PayPalScriptProvider
				options={ {
					clientId: config.scriptData.client_id,
					components: 'card-fields',
					dataNamespace: 'ppcp-block-card-fields',
				} }
			>
				<PayPalCardFieldsProvider
					createVaultSetupToken={
						config.scriptData.is_free_trial_cart
							? createVaultSetupToken
							: undefined
					}
					createOrder={
						config.scriptData.is_free_trial_cart
							? undefined
							: createOrder
					}
					onApprove={
						config.scriptData.is_free_trial_cart
							? onApproveSavePayment
							: onApprove
					}
					onError={ ( err ) => {
						console.error( err );
					} }
				>
					<PayPalCardFieldsForm />
					<CheckoutHandler
						getCardFieldsForm={ getCardFieldsForm }
						getSavePayment={ getSavePayment }
						hasSubscriptionProducts={ hasSubscriptionProducts }
						saveCardText={ config.save_card_text }
						is_vaulting_enabled={ config.is_vaulting_enabled }
					/>
				</PayPalCardFieldsProvider>
			</PayPalScriptProvider>
		</>
	);
}
