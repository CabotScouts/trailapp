import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Stripe } from '@/layouts/admin/frame';
import { __ } from '@/composables/translations';

export default function Submissions({ question, submissions }) {
  return (
    <List submissions={submissions}>
      <Stripe>{__("submissions_for", { for: <span className="font-bold">{question}</span> })}</Stripe>
    </List>
  )
}
